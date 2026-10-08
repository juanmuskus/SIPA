<?php
declare(strict_types=1);

namespace App\Modules\Logistica;

use App\Core\Controller;
use App\Core\Database;

class ConductorController extends Controller
{
    public function indexAction(): void
    {
        $this->listarconductorAction();
    }

    public function listarconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $conductores = Database::fetchAll("SELECT * FROM conductor ORDER BY id_conductor DESC");
        $this->render('logistica/conductor/listar', ['conductores' => $conductores], 'logistica');
    }

    public function agregarconductorAction(): void
    {
        $this->requireAuth([1, 3]);
        $this->render('logistica/conductor/agregar', [], 'logistica');
    }

    public function guardarconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $nom = trim((string)$this->param('nom', ''));
        $ape = trim((string)$this->param('ape', ''));
        $ide = (int)$this->param('ide', 0);
        $tel = trim((string)$this->param('tel', ''));
        $dir = trim((string)$this->param('dir', ''));

        Database::insert('conductor', [
            'nombre'         => $nom,
            'apellido'       => $ape,
            'identificacion' => $ide,
            'telefono'       => $tel,
            'direccion'      => $dir,
            'fecha_registro' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Conductor guardado con éxito";
            exit;
        }

        $this->redirect('/conductor/listarconductor');
    }

    public function editarconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        $conductor = Database::fetch("SELECT * FROM conductor WHERE id_conductor = :id", [':id' => $id]);

        if (!$conductor) {
            $this->redirect('/conductor/listarconductor');
        }

        $this->render('logistica/conductor/editar', ['conductor' => $conductor], 'logistica');
    }

    public function actualizarconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('id', 0);
        $nom = trim((string)$this->param('nom', ''));
        $ape = trim((string)$this->param('ape', ''));
        $ide = (int)$this->param('ide', 0);
        $tel = trim((string)$this->param('tel', ''));
        $dir = trim((string)$this->param('dir', ''));

        Database::update('conductor', [
            'nombre'         => $nom,
            'apellido'       => $ape,
            'identificacion' => $ide,
            'telefono'       => $tel,
            'direccion'      => $dir,
        ], 'id_conductor = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Conductor actualizado con éxito";
            exit;
        }

        $this->redirect('/conductor/listarconductor');
    }

    public function eliminarconductorAction(): void
    {
        $this->requireAuth([1, 3]);

        $id = (int)$this->param('conductor_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('conductor', 'id_conductor = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Conductor eliminado con éxito";
            exit;
        }

        $this->redirect('/conductor/listarconductor');
    }
}
