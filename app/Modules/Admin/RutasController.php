<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Core\Controller;
use App\Core\Database;

class RutasController extends Controller
{
    public function indexAction(): void
    {
        $this->listarrutaAction();
    }

    public function listarrutaAction(): void
    {
        $this->requireAuth([1]);

        $rutas = Database::fetchAll("SELECT * FROM ruta ORDER BY cod_ruta DESC");
        $this->render('admin/rutas/listar', ['rutas' => $rutas], 'admin');
    }

    public function agregarrutaAction(): void
    {
        $this->requireAuth([1]);
        $this->render('admin/rutas/agregar', [], 'admin');
    }

    public function guardarrutaAction(): void
    {
        $this->requireAuth([1]);

        $origen = trim((string)$this->param('origen', ''));
        $destino = trim((string)$this->param('destino', ''));
        $ruta = trim((string)$this->param('ruta', ''));
        $sitio = trim((string)$this->param('sitio', ''));

        Database::insert('ruta', [
            'origen'         => $origen,
            'destino'        => $destino,
            'ruta'           => $ruta,
            'sitio'          => $sitio,
            'registrado'     => 1,
            'fecha_registro' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Ruta guardada con éxito";
            exit;
        }

        $this->redirect('/rutas/listarruta');
    }

    public function editarrutaAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $ruta = Database::fetch("SELECT * FROM ruta WHERE cod_ruta = :id", [':id' => $id]);

        if (!$ruta) {
            $this->redirect('/rutas/listarruta');
        }

        $this->render('admin/rutas/editar', ['ruta' => $ruta], 'admin');
    }

    public function actualizarrutaAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $origen = trim((string)$this->param('origen', ''));
        $destino = trim((string)$this->param('destino', ''));
        $ruta = trim((string)$this->param('ruta', ''));
        $sitio = trim((string)$this->param('sitio', ''));

        Database::update('ruta', [
            'origen'  => $origen,
            'destino' => $destino,
            'ruta'    => $ruta,
            'sitio'   => $sitio,
        ], 'cod_ruta = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Ruta actualizada con éxito";
            exit;
        }

        $this->redirect('/rutas/listarruta');
    }

    public function eliminarrutaAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('ruta_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('ruta', 'cod_ruta = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Ruta eliminada con éxito";
            exit;
        }

        $this->redirect('/rutas/listarruta');
    }
}
