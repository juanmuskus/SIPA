<?php
declare(strict_types=1);

namespace App\Modules\Logistica;

use App\Core\Controller;
use App\Core\Database;

class ServicioController extends Controller
{
    public function indexAction(): void
    {
        $this->listarservicioAction();
    }

    public function listarservicioAction(): void
    {
        $this->requireAuth([1, 3]);

        $sql = "SELECT s.*, p.num_dias, p.cod_practica 
                FROM servicio s 
                LEFT JOIN programacion p ON s.codigo_prog = p.codigo_prog 
                ORDER BY s.cod_servicio DESC";
        $servicios = Database::fetchAll($sql);

        $this->render('logistica/servicio/listar', ['servicios' => $servicios], 'logistica');
    }

    public function agregarservicioAction(): void
    {
        $this->requireAuth([1, 3]);

        $programaciones = Database::fetchAll("SELECT codigo_prog, num_dias, cod_practica, lugar_encuentro 
                                              FROM programacion ORDER BY codigo_prog DESC");

        $this->render('logistica/servicio/agregar', ['programaciones' => $programaciones], 'logistica');
    }

    public function guardarservicioAction(): void
    {
        $this->requireAuth([1, 3]);

        $tipo = trim((string)$this->param('servicio', $this->param('tipo', '')));
        $valor = (float)$this->param('valor', 0);
        $codProg = (int)$this->param('codigo_prog', $this->param('programacion', 0));
        $obs = trim((string)$this->param('observacion', ''));

        Database::insert('servicio', [
            'tipo'           => $tipo,
            'valor'          => $valor,
            'codigo_prog'    => $codProg,
            'observacion'    => $obs,
            'fecha_registro' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Servicio guardado con éxito";
            exit;
        }

        $this->redirect('/servicio/listarservicio');
    }

    public function editarservicioAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        $servicio = Database::fetch("SELECT * FROM servicio WHERE cod_servicio = :id", [':id' => $id]);

        if (!$servicio) {
            $this->redirect('/servicio/listarservicio');
        }

        $programaciones = Database::fetchAll("SELECT codigo_prog, num_dias, cod_practica, lugar_encuentro 
                                              FROM programacion ORDER BY codigo_prog DESC");

        $this->render('logistica/servicio/editar', [
            'servicio'       => $servicio,
            'programaciones' => $programaciones
        ], 'logistica');
    }

    public function actualizarservicioAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        $tipo = trim((string)$this->param('servicio', $this->param('tipo', '')));
        $valor = (float)$this->param('valor', 0);
        $codProg = (int)$this->param('codigo_prog', $this->param('programacion', 0));
        $obs = trim((string)$this->param('observacion', ''));

        Database::update('servicio', [
            'tipo'        => $tipo,
            'valor'       => $valor,
            'codigo_prog' => $codProg,
            'observacion' => $obs,
        ], 'cod_servicio = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Servicio actualizado con éxito";
            exit;
        }

        $this->redirect('/servicio/listarservicio');
    }

    public function eliminarservicioAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('servicio_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('servicio', 'cod_servicio = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Servicio eliminado con éxito";
            exit;
        }

        $this->redirect('/servicio/listarservicio');
    }
}
