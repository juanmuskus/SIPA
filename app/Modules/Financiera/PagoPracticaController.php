<?php
declare(strict_types=1);

namespace App\Modules\Financiera;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class PagoPracticaController extends Controller
{
    public function indexAction(): void
    {
        $this->listarliquidacionAction();
    }

    public function listarliquidacionAction(): void
    {
        $this->requireAuth([1, 4]);

        $sql = "SELECT l.*, p.nombre AS practica_nombre, p.num_estudiantes, p.asignatura, p.nom_solicitante 
                FROM liquidar_practica l 
                LEFT JOIN practica p ON l.cod_practica = p.cod_practica 
                ORDER BY l.id_liquidar DESC";
        $liquidaciones = Database::fetchAll($sql);

        $docMap = [];
        try {
            $allDocs = Database::fetchAll("SELECT cod_empl, nom_empl, ape_empl FROM view_sipa", [], 'kactus');
            foreach ($allDocs as $ad) {
                $docMap[(string)$ad['cod_empl']] = trim($ad['nom_empl'] . ' ' . $ad['ape_empl']);
            }
        } catch (\Throwable) {}

        foreach ($liquidaciones as &$liq) {
            $liq['total'] = (float)$liq['viaticos'] + (float)$liq['aux_estudiante'] + (float)$liq['transporte_especial'];
            $liq['docente_nombre'] = $docMap[(string)$liq['nom_solicitante']] ?? 'Docente ' . $liq['nom_solicitante'];
        }

        $roleId = Session::roleId();
        $layout = $roleId === 4 ? 'financiera' : 'admin';
        $this->render('financiera/pago_practica', ['liquidaciones' => $liquidaciones], $layout);
    }

    public function liquidarpracticaAction(): void
    {
        $this->requireAuth([1, 4]);

        $codPractica = (int)$this->param('cod_practica', $this->param('id', 0));
        $practica = Database::fetch("SELECT * FROM practica WHERE cod_practica = :id", [':id' => $codPractica]);

        if (!$practica) {
            $this->redirect('/practicas/listarpractica');
        }

        $programaciones = Database::fetchAll("SELECT p.*, r.origen, r.destino, r.sitio 
                                              FROM programacion p 
                                              LEFT JOIN ruta r ON p.recorrido = r.cod_ruta 
                                              WHERE p.cod_practica = :id 
                                              ORDER BY p.num_dias ASC", [':id' => $codPractica]);

        $daysCount = count($programaciones);
        $firstSite = $programaciones[0]['sitio'] ?? 'Municipio';

        // Viáticos docente calculation
        if (strcasecmp($firstSite, 'Departamento') === 0) {
            $valorDocente = $daysCount === 1 ? 79250 : ($daysCount * 158574) - 79250;
        } else {
            $valorDocente = $daysCount === 1 ? 51709 : ($daysCount * 103418) - 51709;
        }

        // Student aid calculation based on pernoctado
        $numEst = (int)($practica['num_estudiantes'] ?? 0);
        $auxilioEst = 0;
        foreach ($programaciones as $dia) {
            if (strcasecmp((string)$dia['dias_pernoctados'], 'Si') === 0) {
                $auxilioEst += 31025 * $numEst;
            }
        }

        // Special transport calculation
        $transporteEspecial = 0;
        if (!empty($programaciones)) {
            $progIds = array_map(fn($p) => (int)$p['codigo_prog'], $programaciones);
            $inList = implode(',', $progIds);
            $sum = Database::fetchColumn("SELECT SUM(pr.valor) 
                                          FROM recursos_programados rp 
                                          JOIN programacion_recursos pr ON rp.id_pro = pr.id_pro 
                                          WHERE rp.codigo_prog IN ({$inList})");
            $transporteEspecial = (float)($sum ?: 0);
        }

        $existente = Database::fetch("SELECT * FROM liquidar_practica WHERE cod_practica = :id", [':id' => $codPractica]);

        $roleId = Session::roleId();
        $layout = $roleId === 4 ? 'financiera' : 'admin';

        $this->render('admin/liquidar/liquidar_docente', [
            'practica'           => $practica,
            'programaciones'     => $programaciones,
            'valor_docente'      => $valorDocente,
            'auxilio_est'        => $auxilioEst,
            'transporte_especial'=> $transporteEspecial,
            'existente'          => $existente,
            'cod_practica'       => $codPractica
        ], $layout);
    }

    public function guardarliquidarpracticasAction(): void
    {
        $this->requireAuth([1, 4]);

        $codPractica = (int)$this->param('practica', $this->param('cod_practica', 0));
        $viaticos = (float)$this->param('viatico_docente', $this->param('viaticos', 0));
        $auxEst = (float)$this->param('auxilio_estudiante', $this->param('aux_estudiante', 0));
        $transEsp = (float)$this->param('transporte_especial', 0);
        $estado = (string)$this->param('estado_pago', $this->param('estado', 'Trámite'));
        $fPago = $this->formatDate((string)$this->param('fecha_pago', ''));
        $legalizado = (string)$this->param('legalizado', 'No');
        $fLegalizado = $this->formatDate((string)$this->param('fecha_legalizado', ''));

        $exist = Database::fetch("SELECT id_liquidar FROM liquidar_practica WHERE cod_practica = :p", [':p' => $codPractica]);

        $data = [
            'viaticos'            => $viaticos,
            'aux_estudiante'      => $auxEst,
            'transporte_especial' => $transEsp,
            'estado'              => $estado,
            'fecha_pago'          => $fPago,
            'legalizado'          => $legalizado,
            'fecha_legalizado'    => $fLegalizado,
            'fecha_modificacion'  => date('Y-m-d H:i:s'),
            'cod_practica'        => $codPractica,
        ];

        if ($exist) {
            Database::update('liquidar_practica', $data, 'id_liquidar = :id', [':id' => $exist['id_liquidar']]);
        } else {
            Database::insert('liquidar_practica', $data);
        }

        if ($this->request->isAjax()) {
            echo "Liquidación registrada con éxito";
            exit;
        }

        $this->redirect('/liquidarpracticas/listarliquidacion');
    }

    public function editarliquidacionAction(): void
    {
        $this->requireAuth([1, 4]);

        $id = (int)$this->param('id', $this->param('cod_practica', 0));
        $liquidacion = Database::fetch("SELECT l.*, p.nombre AS practica_nombre 
                                        FROM liquidar_practica l 
                                        LEFT JOIN practica p ON l.cod_practica = p.cod_practica 
                                        WHERE l.id_liquidar = :id OR l.cod_practica = :id", [':id' => $id]);

        if (!$liquidacion) {
            $this->redirect('/liquidarpracticas/listarliquidacion');
        }

        $roleId = Session::roleId();
        $layout = $roleId === 4 ? 'financiera' : 'admin';

        $this->render('financiera/editar_pago', ['liquidacion' => $liquidacion], $layout);
    }

    public function actualizarliquidarpracticasAction(): void
    {
        $this->requireAuth([1, 4]);

        $id = (int)$this->param('id_liquidar', $this->param('id', 0));
        $viaticos = (float)$this->param('viatico_docente', $this->param('viaticos', 0));
        $auxEst = (float)$this->param('auxilio_estudiante', $this->param('aux_estudiante', 0));
        $transEsp = (float)$this->param('transporte_especial', 0);
        $estado = (string)$this->param('estado_pago', $this->param('estado', 'Pagado'));
        $fPago = $this->formatDate((string)$this->param('fecha_pago', ''));
        $legalizado = (string)$this->param('legalizado', 'Si');
        $fLegalizado = $this->formatDate((string)$this->param('fecha_legalizado', ''));

        Database::update('liquidar_practica', [
            'viaticos'            => $viaticos,
            'aux_estudiante'      => $auxEst,
            'transporte_especial' => $transEsp,
            'estado'              => $estado,
            'fecha_pago'          => $fPago,
            'legalizado'          => $legalizado,
            'fecha_legalizado'    => $fLegalizado,
            'fecha_modificacion'  => date('Y-m-d H:i:s'),
        ], 'id_liquidar = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Pago actualizado con éxito";
            exit;
        }

        $this->redirect('/liquidarpracticas/listarliquidacion');
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
