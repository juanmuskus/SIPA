<?php
declare(strict_types=1);

namespace App\Modules\Logistica;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class LiquidacionConductorController extends Controller
{
    public function indexAction(): void
    {
        $this->listarliquiconductorAction();
    }

    public function listarliquiconductorAction(): void
    {
        $this->requireAuth([1, 3, 4]);

        $sql = "SELECT l.*, 
                       c.nombre AS conductor_nombre, c.apellido AS conductor_apellido,
                       v.placa, v.descripcion AS vehiculo_desc,
                       p.nombre AS practica_nombre
                FROM liquidacion_conductor l
                LEFT JOIN conductor c ON l.id_conductor = c.id_conductor
                LEFT JOIN transporte v ON l.cod_transporte = v.cod_transporte
                LEFT JOIN practica p ON l.cod_practica = p.cod_practica
                ORDER BY l.id DESC";
        $liquidaciones = Database::fetchAll($sql);

        foreach ($liquidaciones as &$liq) {
            $liq['total'] = (float)$liq['combustible'] + (float)$liq['peajes'] + (float)$liq['viaticos'] + (float)$liq['imprevistos'];
        }

        $roleId = Session::roleId();
        $layout = match ($roleId) {
            1 => 'admin',
            3 => 'logistica',
            4 => 'financiera',
            default => 'logistica'
        };

        $this->render('logistica/liquidacion/listar', ['liquidaciones' => $liquidaciones], $layout);
    }

    public function agregarliquiconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $conductores = Database::fetchAll("SELECT * FROM conductor ORDER BY nombre ASC");
        $vehiculos = Database::fetchAll("SELECT * FROM transporte ORDER BY placa ASC");
        $practicas = Database::fetchAll("SELECT cod_practica, nombre FROM practica ORDER BY cod_practica DESC");

        $this->render('logistica/liquidacion/agregar', [
            'conductores' => $conductores,
            'vehiculos'   => $vehiculos,
            'practicas'   => $practicas
        ], 'logistica');
    }

    public function guardarliquiconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $combustible = (float)$this->param('combustible', 0);
        $peajes = (float)$this->param('peajes', 0);
        $viaticos = (float)$this->param('viaticos', 0);
        $imprevistos = (float)$this->param('imprevistos', 0);
        $estado = (string)$this->param('estado_pago', $this->param('pagado', 'Trámite'));
        $fPago = $this->formatDate((string)$this->param('fecha_pago', ''));
        $legalizado = (string)$this->param('legalizado', 'No');
        $fLegalizado = $this->formatDate((string)$this->param('fecha_legalizado', ''));
        $idConductor = (int)$this->param('conductor', $this->param('id_conductor', 0));
        $codVehiculo = (int)$this->param('vehiculo', $this->param('cod_transporte', 0));
        $codPractica = (int)$this->param('practica', $this->param('cod_practica', 0));
        $obs = trim((string)$this->param('observacion', ''));

        Database::insert('liquidacion_conductor', [
            'combustible'      => $combustible,
            'peajes'           => $peajes,
            'viaticos'         => $viaticos,
            'imprevistos'      => $imprevistos,
            'pagado'           => $estado,
            'fecha_pago'       => $fPago,
            'legalizado'       => $legalizado,
            'fecha_legalizado' => $fLegalizado,
            'id_conductor'     => $idConductor,
            'cod_transporte'   => $codVehiculo,
            'cod_practica'     => $codPractica,
            'observacion'      => $obs,
            'fecha_registro'   => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Liquidación guardada con éxito";
            exit;
        }

        $this->redirect('/liquiconductor/listarliquiconductor');
    }

    public function listarproliquiconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $sql = "SELECT p.*, pra.nombre AS practica_nombre, pra.num_estudiantes, r.origen, r.destino 
                FROM programacion p 
                LEFT JOIN practica pra ON p.cod_practica = pra.cod_practica 
                LEFT JOIN ruta r ON p.recorrido = r.cod_ruta 
                ORDER BY p.codigo_prog DESC";
        $programaciones = Database::fetchAll($sql);

        $this->render('logistica/programaciones', ['programaciones' => $programaciones], 'logistica');
    }

    public function verliquidacionAction(): void
    {
        $this->requireAuth([1, 4]);

        $sql = "SELECT l.*, 
                       c.nombre AS conductor_nombre, c.apellido AS conductor_apellido,
                       v.placa, v.descripcion AS vehiculo_desc,
                       p.nombre AS practica_nombre
                FROM liquidacion_conductor l
                LEFT JOIN conductor c ON l.id_conductor = c.id_conductor
                LEFT JOIN transporte v ON l.cod_transporte = v.cod_transporte
                LEFT JOIN practica p ON l.cod_practica = p.cod_practica
                ORDER BY l.id DESC";
        $liquidaciones = Database::fetchAll($sql);

        foreach ($liquidaciones as &$liq) {
            $liq['total'] = (float)$liq['combustible'] + (float)$liq['peajes'] + (float)$liq['viaticos'] + (float)$liq['imprevistos'];
        }

        $this->render('financiera/pago_logistica', ['liquidaciones' => $liquidaciones], 'financiera');
    }

    public function editarliquiconductorAction(): void
    {
        $this->requireAuth([1, 3, 4]);

        $id = (int)$this->param('id', 0);
        $liquidacion = Database::fetch("SELECT l.*, c.nombre AS c_nom, c.apellido AS c_ape, v.placa 
                                        FROM liquidacion_conductor l 
                                        LEFT JOIN conductor c ON l.id_conductor = c.id_conductor 
                                        LEFT JOIN transporte v ON l.cod_transporte = v.cod_transporte 
                                        WHERE l.id = :id", [':id' => $id]);

        if (!$liquidacion) {
            $this->redirect('/liquiconductor/listarliquiconductor');
        }

        $conductores = Database::fetchAll("SELECT * FROM conductor ORDER BY nombre ASC");
        $vehiculos = Database::fetchAll("SELECT * FROM transporte ORDER BY placa ASC");
        $practicas = Database::fetchAll("SELECT cod_practica, nombre FROM practica ORDER BY cod_practica DESC");

        $roleId = Session::roleId();
        $layout = $roleId === 4 ? 'financiera' : 'logistica';

        $this->render('logistica/liquidacion/editar', [
            'liquidacion' => $liquidacion,
            'conductores' => $conductores,
            'vehiculos'   => $vehiculos,
            'practicas'   => $practicas
        ], $layout);
    }

    public function actualizarliquiconductorAction(): void
    {
        $this->requireAuth([1, 3, 4]);

        $id = (int)$this->param('id', 0);
        $combustible = (float)$this->param('combustible', 0);
        $peajes = (float)$this->param('peajes', 0);
        $viaticos = (float)$this->param('viaticos', 0);
        $imprevistos = (float)$this->param('imprevistos', 0);
        $estado = (string)$this->param('pagada', $this->param('pagado', $this->param('estado_pago', 'Pagado')));
        $fPago = $this->formatDate((string)$this->param('fecha_pago', ''));
        $legalizado = (string)$this->param('legalizado', 'Si');
        $fLegalizado = $this->formatDate((string)$this->param('fecha_legalizado', ''));
        $obs = trim((string)$this->param('observacion', ''));

        Database::update('liquidacion_conductor', [
            'combustible'      => $combustible,
            'peajes'           => $peajes,
            'viaticos'         => $viaticos,
            'imprevistos'      => $imprevistos,
            'pagado'           => $estado,
            'fecha_pago'       => $fPago,
            'legalizado'       => $legalizado,
            'fecha_legalizado' => $fLegalizado,
            'observacion'      => $obs,
        ], 'id = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Liquidación actualizada con éxito";
            exit;
        }

        if (Session::roleId() === 4) {
            $this->redirect('/liquiconductor/verliquidacion');
        } else {
            $this->redirect('/liquiconductor/listarliquiconductor');
        }
    }

    public function eliminarliquiconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        if ($id > 0) {
            Database::delete('liquidacion_conductor', 'id = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Liquidación eliminada con éxito";
            exit;
        }

        $this->redirect('/liquiconductor/listarliquiconductor');
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
