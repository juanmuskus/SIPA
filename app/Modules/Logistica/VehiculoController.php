<?php
declare(strict_types=1);

namespace App\Modules\Logistica;

use App\Core\Controller;
use App\Core\Database;

class VehiculoController extends Controller
{
    public function indexAction(): void
    {
        $this->listartransporteAction();
    }

    public function listartransporteAction(): void
    {
        $this->requireAuth([1, 3]);

        $vehiculos = Database::fetchAll("SELECT * FROM transporte ORDER BY cod_transporte DESC");
        $this->render('logistica/transporte/listar', ['vehiculos' => $vehiculos], 'logistica');
    }

    public function agregartransporteAction(): void
    {
        $this->requireAuth([1, 3]);
        $this->render('logistica/transporte/agregar', [], 'logistica');
    }

    public function guardartransporteAction(): void
    {
        $this->requireAuth([1, 3]);

        $placa = strtoupper(trim((string)$this->param('pla', $this->param('placa', ''))));
        $desc = trim((string)$this->param('des', $this->param('descripcion', '')));
        $tipo = trim((string)$this->param('tip', $this->param('tipo_vehiculo', '')));
        $estado = trim((string)$this->param('est', $this->param('estado_vehiculo', '')));
        $capacidad = trim((string)$this->param('cap', $this->param('capacidad_pasajeros', '')));

        Database::insert('transporte', [
            'placa'               => $placa,
            'descripcion'         => $desc,
            'tipo_vehiculo'       => $tipo,
            'estado_vehiculo'     => $estado,
            'capacidad_pasajeros' => $capacidad,
            'fecha_registro'      => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Vehículo guardado con éxito";
            exit;
        }

        $this->redirect('/transporte/listartransporte');
    }

    public function editartransporteAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        $vehiculo = Database::fetch("SELECT * FROM transporte WHERE cod_transporte = :id", [':id' => $id]);

        if (!$vehiculo) {
            $this->redirect('/transporte/listartransporte');
        }

        $this->render('logistica/transporte/editar', ['vehiculo' => $vehiculo], 'logistica');
    }

    public function actualizartransporteAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        $placa = strtoupper(trim((string)$this->param('pla', $this->param('placa', ''))));
        $desc = trim((string)$this->param('des', $this->param('descripcion', '')));
        $tipo = trim((string)$this->param('tip', $this->param('tipo_vehiculo', '')));
        $estado = trim((string)$this->param('est', $this->param('estado_vehiculo', '')));
        $capacidad = trim((string)$this->param('cap', $this->param('capacidad_pasajeros', '')));

        Database::update('transporte', [
            'placa'               => $placa,
            'descripcion'         => $desc,
            'tipo_vehiculo'       => $tipo,
            'estado_vehiculo'     => $estado,
            'capacidad_pasajeros' => $capacidad,
        ], 'cod_transporte = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Vehículo actualizado con éxito";
            exit;
        }

        $this->redirect('/transporte/listartransporte');
    }

    public function eliminartransporteAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('transporte_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('transporte', 'cod_transporte = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Vehículo eliminado con éxito";
            exit;
        }

        $this->redirect('/transporte/listartransporte');
    }
}
