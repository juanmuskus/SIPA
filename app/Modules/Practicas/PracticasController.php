<?php
declare(strict_types=1);

namespace App\Modules\Practicas;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class PracticasController extends Controller
{
    public function indexAction(): void
    {
        $this->requireAuth([1, 2]);
        $layout = Session::roleId() === 1 ? 'admin' : 'departamento';
        $this->render('practicas/index', [], $layout);
    }

    public function listarpracticaAction(): void
    {
        $this->requireAuth([1, 2]);
        $roleId = Session::roleId();
        $user = Session::user();

        $sql = "SELECT p.*, 
                       c.fecha_inicio AS cal_inicio, c.fecha_fin AS cal_fin,
                       l.id_liquidar, l.estado AS estado_liq, l.viaticos, l.aux_estudiante, 
                       l.transporte_especial, l.fecha_pago, l.legalizado, l.fecha_legalizado
                FROM practica p
                LEFT JOIN calendario_practica c ON p.id_calendario = c.id
                LEFT JOIN liquidar_practica l ON p.cod_practica = l.cod_practica";

        $params = [];
        // If Department role, filter by user program if specified
        if ($roleId === 2 && !empty($user['cod_progra_power']) && $user['cod_progra_power'] !== '0') {
            $sql .= " WHERE p.programa = :prog";
            $params[':prog'] = $user['cod_progra_power'];
        }

        $sql .= " ORDER BY p.cod_practica DESC";
        $practicas = Database::fetchAll($sql, $params);

        // Fetch program and subject names
        $progNames = [];
        try {
            $allProgs = Database::fetchAll("SELECT ID_Programa, Programa FROM v_programas", [], 'campus');
            foreach ($allProgs as $ap) {
                $progNames[(string)$ap['ID_Programa']] = $ap['Programa'];
            }
        } catch (\Throwable) {}

        $docMap = [];
        try {
            $allDocs = Database::fetchAll("SELECT cod_empl, nom_empl, ape_empl FROM view_sipa", [], 'kactus');
            foreach ($allDocs as $ad) {
                $docMap[(string)$ad['cod_empl']] = trim($ad['nom_empl'] . ' ' . $ad['ape_empl']);
            }
        } catch (\Throwable) {}

        foreach ($practicas as &$pr) {
            $pr['programa_nombre'] = $progNames[(string)$pr['programa']] ?? $pr['programa'];
            $pr['docente_nombre'] = $docMap[(string)$pr['nom_solicitante']] ?? 'Docente ' . $pr['nom_solicitante'];
        }

        $layout = $roleId === 1 ? 'admin' : 'departamento';
        $this->render('practicas/listar', [
            'practicas' => $practicas,
            'rol'       => $roleId
        ], $layout);
    }

    public function agregarpracticaAction(): void
    {
        $this->requireAuth([1, 2]);
        $roleId = Session::roleId();
        $user = Session::user();
        $id = (int)$this->param('id', 0);
        $practica = null;
        $programaciones = [];

        if ($id > 0) {
            $practica = Database::fetch(
                "SELECT * FROM practica WHERE cod_practica = :id",
                [':id' => $id]
            );
            if ($practica === null) {
                http_response_code(404);
                $this->render('errors/404', ['path' => '/practicas/editarpractica'], null);
                return;
            }

            if ($roleId === 2 && (string)$practica['programa'] !== (string)($user['cod_progra_power'] ?? '')) {
                $this->redirect('/practicas/listarpractica');
                return;
            }

            $programaciones = Database::fetchAll(
                "SELECT p.*, r.origen, r.destino, r.sitio, r.ruta AS ruta_nombre
                 FROM programacion p
                 LEFT JOIN ruta r ON p.recorrido = r.cod_ruta
                 WHERE p.cod_practica = :id
                 ORDER BY p.num_dias ASC",
                [':id' => $id]
            );

            foreach ($programaciones as &$programacion) {
                $programacion['participantes'] = Database::fetchAll(
                    "SELECT par.*
                     FROM programacion_participante pp
                     JOIN participante par ON pp.id_participante = par.id_participante
                     WHERE pp.codigo_prog = :id",
                    [':id' => $programacion['codigo_prog']]
                );
                $programacion['recursos'] = Database::fetchAll(
                    "SELECT pr.id_pro, pr.valor, re.nombre
                     FROM recursos_programados rp
                     JOIN programacion_recursos pr ON rp.id_pro = pr.id_pro
                     JOIN recursos_especiales re ON pr.id_recursos = re.id_recursos
                     WHERE rp.codigo_prog = :id",
                    [':id' => $programacion['codigo_prog']]
                );
            }
            unset($programacion);
        }

        // Active calendar
        $calendario = Database::fetchAll("SELECT c.*, a.annio AS annio_nombre, p.periodo AS periodo_nombre 
                                          FROM calendario_practica c 
                                          LEFT JOIN annio a ON c.id_annio = a.id_annio 
                                          LEFT JOIN periodo p ON c.id_periodo = p.id_periodo 
                                          WHERE c.estado = 1 LIMIT 1");

        // Teachers from Kactus
        try {
            $docentes = Database::fetchAll("SELECT DISTINCT cod_empl AS cod, ape_empl AS ape, nom_empl AS nom 
                                            FROM view_sipa ORDER BY ape_empl", [], 'kactus');
        } catch (\Throwable) {
            $docentes = [];
        }

        // Assistants and advisors
        $auxiliares = Database::fetchAll("SELECT * FROM participante WHERE tipo_participante = 'auxiliar'");
        $asesores = Database::fetchAll("SELECT * FROM participante WHERE tipo_participante = 'asesor'");

        // Routes and special resources
        $rutas = Database::fetchAll("SELECT * FROM ruta ORDER BY origen, destino");
        $recursos = Database::fetchAll("SELECT * FROM recursos_especiales ORDER BY nombre");

        // Faculties
        $facultades = [];
        try {
            if ($roleId === 1) {
                $facultades = Database::fetchAll("SELECT ID AS id_facultad, Facultad AS nombre FROM v_facultades ORDER BY ID", [], 'campus');
            } else {
                // Role 2: filter by user assigned program
                $userProg = $user['cod_progra_power'] ?? 0;
                $sqlFac = "SELECT DISTINCT f.Facultad AS nombre, f.ID AS id_facultad, 
                                           d.ID_Departamento AS id_dep, d.Departamento AS dep, 
                                           p.ID_Programa AS id_pro, p.Programa AS pro 
                           FROM v_departamentos d 
                           INNER JOIN v_facultades f ON d.ID_Facultad = f.ID 
                           INNER JOIN v_programas p ON d.ID_Departamento = p.ID_Departamento 
                           WHERE p.ID_Programa = :prog";
                $facultades = Database::fetchAll($sqlFac, [':prog' => $userProg], 'campus');
            }
        } catch (\Throwable) {
            $facultades = Database::fetchAll("SELECT id_facultad, nombre FROM facultad");
        }

        $layout = $roleId === 1 ? 'admin' : 'departamento';
        $this->render('practicas/agregar', [
            'calendario'  => $calendario,
            'docentes'    => $docentes,
            'auxiliares'  => $auxiliares,
            'asesores'    => $asesores,
            'rutas'       => $rutas,
            'recursos'    => $recursos,
            'facultades'  => $facultades,
            'rol'         => $roleId,
            'user'        => $user,
            'practica'     => $practica,
            'programaciones' => $programaciones,
        ], $layout);
    }

    public function editarpracticaAction(): void
    {
        if ((int)$this->param('id', 0) <= 0) {
            $this->redirect('/practicas/listarpractica');
            return;
        }

        $this->agregarpracticaAction();
    }

    public function guardarpracticaAction(): void
    {
        $this->requireAuth([1, 2]);

        $datosRaw = (string)$this->param('datos', '');
        parse_str($datosRaw, $output);

        $programacion = $this->param('programacion', []);
        $idPractica = (int)$this->param('id', 0);
        $roleId = Session::roleId();
        $user = Session::user();

        if ($idPractica > 0) {
            $existingPractice = Database::fetch(
                "SELECT id_calendario, programa FROM practica WHERE cod_practica = :id",
                [':id' => $idPractica]
            );
            if ($existingPractice === null) {
                http_response_code(404);
                echo 'La práctica que intenta actualizar no existe.';
                exit;
            }
            if ($roleId === 2 &&
                (string)$existingPractice['programa'] !== (string)($user['cod_progra_power'] ?? '') ) {
                http_response_code(403);
                echo 'No tiene permiso para modificar esta práctica.';
                exit;
            }
            $idCalendario = $existingPractice['id_calendario'];
        } else {
            $calendarioActivo = Database::fetch("SELECT id FROM calendario_practica WHERE estado = 1 LIMIT 1");
            if ($calendarioActivo === null) {
                http_response_code(422);
                echo 'No hay un calendario académico activo para registrar prácticas.';
                exit;
            }
            $idCalendario = $calendarioActivo['id'];
        }

        if ($roleId === 2 &&
            (string)($output['pro'] ?? '') !== (string)($user['cod_progra_power'] ?? '')) {
            http_response_code(403);
            echo 'El programa seleccionado no corresponde a su usuario.';
            exit;
        }

        try {
            Database::beginTransaction();

            $practicaData = [
                'id_calendario'   => $idCalendario,
                'nombre'          => $output['nom'] ?? 'Práctica',
                'num_estudiantes' => $output['num'] ?? '0',
                'nom_solicitante' => (int)($output['nombre'] ?? 0),
                'justificacion'   => $output['jus'] ?? '',
                'objetivo'        => $output['obj'] ?? '',
                'actividad_doc'   => $output['adoc'] ?? '',
                'actividad_est'   => $output['est'] ?? '',
                'tipo_practica'   => $output['tipo'] ?? 'Prácticas Externas de laboratorio',
                'semestre'        => (int)($output['sem'] ?? 1),
                'facultad'        => (int)($output['fac'] ?? 1),
                'departamento'    => (string)($output['dep'] ?? ''),
                'programa'        => (int)($output['pro'] ?? 0),
                'asignatura'      => (string)($output['asigna'] ?? ''),
                'grupo'           => (string)($output['gru'] ?? ''),
                'fecha_registro'  => date('Y-m-d H:i:s'),
            ];

            if ($idPractica > 0) {
                Database::update('practica', $practicaData, 'cod_practica = :id', [':id' => $idPractica]);
                // Delete existing program dependencies if updating
                Database::delete('recursos_programados', 'codigo_prog IN (SELECT codigo_prog FROM programacion WHERE cod_practica = :p)', [':p' => $idPractica]);
                Database::delete('programacion_participante', 'codigo_prog IN (SELECT codigo_prog FROM programacion WHERE cod_practica = :p)', [':p' => $idPractica]);
                Database::delete('programacion', 'cod_practica = :p', [':p' => $idPractica]);
                $codPractica = $idPractica;
            } else {
                $codPractica = Database::insert('practica', $practicaData);
            }

            // Insert daily programs
            if (is_array($programacion)) {
                foreach ($programacion as $dia) {
                    $numDia = (string)($dia[0] ?? '1');
                    $recorridoId = !empty($dia[1]) ? (int)$dia[1] : null;
                    $fSalidaStr = (string)($dia[2] ?? '');
                    $lugar = (string)($dia[3] ?? '');
                    $pernoctado = (string)($dia[4] ?? 'No');
                    $fLlegadaStr = (string)($dia[5] ?? '');
                    $auxiliarId = !empty($dia[6]) ? (int)$dia[6] : 0;
                    $asesorId = !empty($dia[7]) ? (int)$dia[7] : 0;
                    $departamental = (string)($dia[8] ?? '');
                    $observaciones = (string)($dia[9] ?? '');
                    $recursosIdsStr = (string)($dia[11] ?? '');

                    $fSalida = $this->formatDate($fSalidaStr);
                    $fLlegada = !empty($fLlegadaStr) ? $this->formatDate($fLlegadaStr) : null;

                    $codProg = Database::insert('programacion', [
                        'cod_practica'     => $codPractica,
                        'num_dias'         => $numDia,
                        'recorrido'        => $recorridoId ? (string)$recorridoId : null,
                        'fecha_salida'     => $fSalida,
                        'fecha_llegada'    => $fLlegada,
                        'departamental'    => $departamental,
                        'lugar_encuentro'  => $lugar,
                        'dias_pernoctados' => $pernoctado,
                        'observaciones'    => $observaciones,
                        'fecha_registro'   => date('Y-m-d H:i:s'),
                    ]);

                    // Add participants
                    if ($auxiliarId > 0) {
                        Database::insert('programacion_participante', [
                            'id_participante' => $auxiliarId,
                            'codigo_prog'     => $codProg
                        ]);
                    }
                    if ($asesorId > 0) {
                        Database::insert('programacion_participante', [
                            'id_participante' => $asesorId,
                            'codigo_prog'     => $codProg
                        ]);
                    }

                    // Add special resources
                    if ($recursosIdsStr !== '') {
                        $recArr = explode(',', $recursosIdsStr);
                        foreach ($recArr as $rId) {
                            $rId = (int)trim($rId);
                            if ($rId > 0) {
                                Database::insert('recursos_programados', [
                                    'id_pro'      => $rId,
                                    'codigo_prog' => $codProg
                                ]);
                            }
                        }
                    }
                }
            }

            Database::commit();

            if ($this->request->isAjax()) {
                echo "Práctica guardada con éxito";
                exit;
            }

            $this->redirect('/practicas/listarpractica');
        } catch (\Throwable $e) {
            Database::rollBack();
            error_log('SIPA: failed to save practice: ' . $e->getMessage());
            http_response_code(500);
            echo 'No fue posible guardar la práctica. Consulte al administrador si el problema continúa.';
            exit;
        }
    }

    public function verliquidacionAction(): void
    {
        $this->requireAuth([1, 2, 4]);

        $id = (int)$this->param('id', $this->param('cod_practica', 0));
        $practica = Database::fetch("SELECT * FROM practica WHERE cod_practica = :id", [':id' => $id]);
        $liquidacion = Database::fetch("SELECT * FROM liquidar_practica WHERE cod_practica = :id", [':id' => $id]);
        $programaciones = Database::fetchAll("SELECT p.*, r.origen, r.destino, r.sitio 
                                              FROM programacion p 
                                              LEFT JOIN ruta r ON p.recorrido = r.cod_ruta 
                                              WHERE p.cod_practica = :id ORDER BY p.num_dias ASC", [':id' => $id]);

        $roleId = Session::roleId();
        $layout = match ($roleId) {
            1 => 'admin',
            2 => 'departamento',
            4 => 'financiera',
            default => 'admin'
        };

        $this->render('practicas/ver_liquidacion', [
            'practica'       => $practica,
            'liquidacion'    => $liquidacion,
            'programaciones' => $programaciones
        ], $layout);
    }

    // ==================== CASCADING AJAX API ENDPOINTS ====================

    public function obtenerverificacioncalendarioAction(): void
    {
        $this->requireAuth([1, 2]);

        $fInicioStr = (string)$this->param('fecha_inicio', '');
        $fFinalStr = (string)$this->param('fecha_final', '');

        $fInicio = $this->formatDate($fInicioStr);
        $fFinal = $this->formatDate($fFinalStr);

        $sql = "SELECT id FROM calendario_practica 
                WHERE estado = 1 
                  AND fecha_inicio <= :fi 
                  AND fecha_fin >= :fi";
        $check = Database::fetchAll($sql, [':fi' => $fInicio]);

        $sql2 = "SELECT id FROM calendario_practica 
                 WHERE estado = 1 
                   AND fecha_inicio <= :ff 
                   AND fecha_fin >= :ff";
        $check2 = Database::fetchAll($sql2, [':ff' => $fFinal]);

        if (!empty($check) || !empty($check2)) {
            $this->json([1]);
        } else {
            $this->json([]);
        }
    }

    public function obtenerprogramasAction(): void
    {
        $this->requireAuth([1, 2]);

        $dep = (int)$this->param('departamento', 0);
        $roleId = Session::roleId();
        $user = Session::user();

        try {
            if ($roleId === 1) {
                $sql = "SELECT DISTINCT ID_Programa, Programa FROM v_programas WHERE ID_Departamento = :dep ORDER BY Programa";
                $data = Database::fetchAll($sql, [':dep' => $dep], 'campus');
            } else {
                $progId = (int)($user['cod_progra_power'] ?? 0);
                $sql = "SELECT DISTINCT ID_Programa, Programa FROM v_programas WHERE ID_Programa = :p";
                $data = Database::fetchAll($sql, [':p' => $progId], 'campus');
            }
        } catch (\Throwable) {
            $data = Database::fetchAll("SELECT id_programa AS ID_Programa, nombre AS Programa FROM programas WHERE cod_facultad = :dep", [':dep' => $dep]);
        }

        $this->json($data);
    }

    public function obtenerdepartamentoAction(): void
    {
        $this->requireAuth([1, 2]);
        $facId = (int)$this->param('facultad', 0);
        $roleId = Session::roleId();
        $user = Session::user();

        try {
            if ($roleId === 1) {
                $sql = "SELECT ID_Departamento AS ID, Departamento AS Departa, ID_Facultad AS id_fa 
                        FROM v_departamentos WHERE ID_Facultad = :fac ORDER BY Departamento";
                $data = Database::fetchAll($sql, [':fac' => $facId], 'campus');
            } else {
                $progId = (int)($user['cod_progra_power'] ?? 0);
                $sql = "SELECT DISTINCT d.ID_Departamento AS ID, d.Departamento AS Departa 
                        FROM v_departamentos d
                        JOIN v_programas p ON d.ID_Departamento = p.ID_Departamento
                        WHERE p.ID_Programa = :p";
                $data = Database::fetchAll($sql, [':p' => $progId], 'campus');
            }
        } catch (\Throwable) {
            $data = Database::fetchAll("SELECT id_programa AS ID, nombre AS Departa FROM programas");
        }

        $this->json($data);
    }

    public function obtenersemestreAction(): void
    {
        $this->requireAuth([1, 2]);
        $idProg = (int)$this->param('programas', $this->param('programa', 0));

        try {
            $sql = "SELECT DISTINCT Semestre AS sem FROM v_asignaturas WHERE Id_Programa = :p ORDER BY CAST(Semestre AS UNSIGNED)";
            $data = Database::fetchAll($sql, [':p' => $idProg], 'campus');
        } catch (\Throwable) {
            $data = [['sem' => '1'], ['sem' => '2'], ['sem' => '3'], ['sem' => '4'], ['sem' => '5'], ['sem' => '6'], ['sem' => '7'], ['sem' => '8'], ['sem' => '9'], ['sem' => '10']];
        }

        $this->json($data);
    }

    public function obtenerasignaturaAction(): void
    {
        $this->requireAuth([1, 2]);
        $semestre = (string)$this->param('semestre', '');
        $idProg = (int)$this->param('programa', 0);

        try {
            $sql = "SELECT DISTINCT Id_Asignatura AS id_asigna, Asignatura AS asigna 
                    FROM v_asignaturas WHERE Semestre = :sem AND Id_Programa = :p ORDER BY Asignatura";
            $data = Database::fetchAll($sql, [':sem' => $semestre, ':p' => $idProg], 'campus');
        } catch (\Throwable) {
            $data = Database::fetchAll("SELECT id_asigna, asigna FROM asignatura");
        }

        $this->json($data);
    }

    public function obtenergruposAction(): void
    {
        $this->requireAuth([1, 2]);
        $asigna = (string)$this->param('asignatura', '');

        try {
            $sql = "SELECT DISTINCT Grupo AS gru FROM v_grupos WHERE ID_Asignatura = :asigna ORDER BY Grupo";
            $data = Database::fetchAll($sql, [':asigna' => $asigna], 'campus');
        } catch (\Throwable) {
            $data = [['gru' => 'Grupo 1'], ['gru' => 'Grupo 2']];
        }

        $this->json($data);
    }

    public function obtenermatriculadosAction(): void
    {
        $this->requireAuth([1, 2]);
        $grupo = (string)$this->param('grupo', '');

        try {
            $sql = "SELECT DISTINCT Matriculados AS mat FROM v_grupos WHERE Grupo = :gru LIMIT 1";
            $data = Database::fetchAll($sql, [':gru' => $grupo], 'campus');
        } catch (\Throwable) {
            $data = [['mat' => '25']];
        }

        $this->json($data);
    }

    public function cargardatosprogramacionAction(): void
    {
        $this->requireAuth([1, 2]);
        $id = (int)$this->param('p', $this->param('id', 0));
        $programas = Database::fetchAll("SELECT p.*, r.origen, r.destino, r.sitio 
                                         FROM programacion p 
                                         LEFT JOIN ruta r ON p.recorrido = r.cod_ruta 
                                         WHERE p.cod_practica = :id", [':id' => $id]);
        $this->json($programas);
    }

    private function formatDate(string $dateStr): string
    {
        $dateStr = trim($dateStr);
        if (str_contains($dateStr, '/')) {
            $parts = explode('/', $dateStr);
            if (count($parts) === 3) {
                return sprintf('%04d-%02d-%02d', (int)$parts[2], (int)$parts[1], (int)$parts[0]);
            }
        }
        return $dateStr ?: date('Y-m-d');
    }
}
