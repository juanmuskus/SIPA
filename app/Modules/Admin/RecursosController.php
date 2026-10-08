<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Core\Controller;
use App\Core\Database;

class RecursosController extends Controller
{
    public function indexAction(): void
    {
        $this->listarrecurespecialesAction();
    }

    public function listarrecurespecialesAction(): void
    {
        $this->requireAuth([1]);

        $recursos = Database::fetchAll("SELECT * FROM recursos_especiales ORDER BY id_recursos DESC");
        $this->render('admin/recursos/listar', ['recursos' => $recursos], 'admin');
    }

    public function agregarrecurespecialesAction(): void
    {
        $this->requireAuth([1]);
        $this->render('admin/recursos/agregar', [], 'admin');
    }

    public function guardarrecurespecialesAction(): void
    {
        $this->requireAuth([1]);

        $nombre = trim((string)$this->param('nom', $this->param('nombre', '')));

        Database::insert('recursos_especiales', [
            'nombre'        => $nombre,
            'fechacreacion' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Recurso especial guardado con éxito";
            exit;
        }

        $this->redirect('/recurespeciales/listarrecurespeciales');
    }

    public function editarrecurespecialesAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $recurso = Database::fetch("SELECT * FROM recursos_especiales WHERE id_recursos = :id", [':id' => $id]);

        if (!$recurso) {
            $this->redirect('/recurespeciales/listarrecurespeciales');
        }

        $this->render('admin/recursos/editar', ['recurso' => $recurso], 'admin');
    }

    public function actualizarrecurespecialesAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $nombre = trim((string)$this->param('nom', $this->param('nombre', '')));

        Database::update('recursos_especiales', [
            'nombre' => $nombre,
        ], 'id_recursos = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Recurso especial actualizado con éxito";
            exit;
        }

        $this->redirect('/recurespeciales/listarrecurespeciales');
    }

    public function eliminarrecurespecialesAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('recurso_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('recursos_especiales', 'id_recursos = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Recurso especial eliminado con éxito";
            exit;
        }

        $this->redirect('/recurespeciales/listarrecurespeciales');
    }
}
