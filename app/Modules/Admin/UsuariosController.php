<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Core\Controller;
use App\Core\Database;

class UsuariosController extends Controller
{
    public function indexAction(): void
    {
        $this->listarusuarioAction();
    }

    public function listarusuarioAction(): void
    {
        $this->requireAuth([1]);

        $sql = "SELECT u.*, r.nombre AS rol_nombre 
                FROM usuario u 
                LEFT JOIN rol r ON u.id_rol = r.id_rol 
                ORDER BY u.id_usuario DESC";
        $usuarios = Database::fetchAll($sql);

        // Fetch program names for each user from campus or local
        $progMap = [];
        try {
            $progs = Database::fetchAll("SELECT ID_Programa, Programa FROM v_programas", [], 'campus');
            foreach ($progs as $p) {
                $progMap[(string)$p['ID_Programa']] = $p['Programa'];
            }
        } catch (\Throwable) {
            $progs = Database::fetchAll("SELECT id_programa, nombre FROM programas");
            foreach ($progs as $p) {
                $progMap[(string)$p['id_programa']] = $p['nombre'];
            }
        }

        foreach ($usuarios as &$u) {
            $pId = (string)($u['cod_progra_power'] ?? '');
            $u['programa_nombre'] = $progMap[$pId] ?? ($pId ?: 'Sin Asignar');
        }

        $this->render('admin/usuarios/listar', ['usuarios' => $usuarios], 'admin');
    }

    public function agregarusuarioAction(): void
    {
        $this->requireAuth([1]);

        // Load programs from campus or fallback
        try {
            $programas = Database::fetchAll("SELECT DISTINCT ID_Programa AS id, Programa AS nombre FROM v_programas ORDER BY Programa", [], 'campus');
        } catch (\Throwable) {
            $programas = Database::fetchAll("SELECT id_programa AS id, nombre FROM programas ORDER BY nombre");
        }

        $roles = Database::fetchAll("SELECT id_rol, nombre FROM rol ORDER BY id_rol");

        $this->render('admin/usuarios/agregar', [
            'programas' => $programas,
            'roles'     => $roles
        ], 'admin');
    }

    public function guardarusuarioAction(): void
    {
        $this->requireAuth([1]);

        $nom = trim((string)$this->param('nom', ''));
        $ape = trim((string)$this->param('ape', ''));
        $ide = (int)$this->param('ide', 0);
        $correo = trim((string)$this->param('correo', ''));
        $usuario = trim((string)$this->param('usuario', ''));
        $pass = (string)$this->param('pass', '');
        $programa = (string)$this->param('programa', '0');
        $rol = (int)$this->param('rol', 2);

        $hashed = hash('sha256', $pass);

        Database::insert('usuario', [
            'nombre'           => $nom,
            'apellidos'        => $ape,
            'identificacion'   => $ide,
            'correo'           => $correo,
            'usuario'          => $usuario,
            'contrasena'       => $hashed,
            'cod_progra_power' => $programa,
            'id_rol'           => $rol,
            'fecha_creacion'   => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Usuario guardado exitosamente";
            exit;
        }

        $this->redirect('/usuarios/listarusuario');
    }

    public function editarusuarioAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $usuario = Database::fetch("SELECT * FROM usuario WHERE id_usuario = :id", [':id' => $id]);

        if (!$usuario) {
            $this->redirect('/usuarios/listarusuario');
        }

        try {
            $programas = Database::fetchAll("SELECT DISTINCT ID_Programa AS id, Programa AS nombre FROM v_programas ORDER BY Programa", [], 'campus');
        } catch (\Throwable) {
            $programas = Database::fetchAll("SELECT id_programa AS id, nombre FROM programas ORDER BY nombre");
        }

        $roles = Database::fetchAll("SELECT id_rol, nombre FROM rol ORDER BY id_rol");

        $this->render('admin/usuarios/editar', [
            'usuario'   => $usuario,
            'programas' => $programas,
            'roles'     => $roles
        ], 'admin');
    }

    public function actualizarusuarioAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $nom = trim((string)$this->param('nom', ''));
        $ape = trim((string)$this->param('ape', ''));
        $ide = (int)$this->param('ide', 0);
        $correo = trim((string)$this->param('correo', ''));
        $usuario = trim((string)$this->param('usuario', ''));
        $programa = (string)$this->param('programa', '0');
        $rol = (int)$this->param('rol', 2);

        $data = [
            'nombre'           => $nom,
            'apellidos'        => $ape,
            'identificacion'   => $ide,
            'correo'           => $correo,
            'usuario'          => $usuario,
            'cod_progra_power' => $programa,
            'id_rol'           => $rol,
        ];

        // Optional password update if provided
        $pass = (string)$this->param('pass', '');
        if ($pass !== '') {
            $data['contrasena'] = hash('sha256', $pass);
        }

        Database::update('usuario', $data, 'id_usuario = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Usuario actualizado con éxito";
            exit;
        }

        $this->redirect('/usuarios/listarusuario');
    }

    public function nuevacontrasenaAction(): void
    {
        $this->requireAuth([1]);
        $usuarios = Database::fetchAll("SELECT id_usuario, nombre, apellidos, usuario FROM usuario ORDER BY nombre");
        $this->render('admin/usuarios/resetear', ['usuarios' => $usuarios], 'admin');
    }

    public function actualizarcontrasenaAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id_usuario', 0);
        $nueva = (string)$this->param('nueva_contrasena', '');

        if ($id > 0 && $nueva !== '') {
            Database::update('usuario', [
                'contrasena' => hash('sha256', $nueva)
            ], 'id_usuario = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Contraseña actualizada";
            exit;
        }

        $this->redirect('/usuarios/listarusuario');
    }

    public function eliminarusuarioAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('usuario_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('usuario', 'id_usuario = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Usuario eliminado con éxito";
            exit;
        }

        $this->redirect('/usuarios/listarusuario');
    }
}
