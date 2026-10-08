<?php
declare(strict_types=1);

namespace App\Modules\Auth;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class AuthController extends Controller
{
    public function index(): void
    {
        if (Session::isLoggedIn()) {
            $this->autorizar();
            return;
        }

        $this->render('auth/login', [], null);
    }

    public function autenticar(): void
    {
        $user = trim((string)$this->param('user', ''));
        $pass = (string)$this->param('pass', '');

        if ($user === '' || $pass === '') {
            http_response_code(400);
            echo "Usuario y contraseña requeridos";
            exit;
        }

        $sql = "SELECT u.*, r.nombre AS rol_nombre, r.id_rol 
                FROM usuario u 
                JOIN rol r ON u.id_rol = r.id_rol 
                WHERE u.usuario = :user LIMIT 1";

        $usuario = Database::fetch($sql, [':user' => $user]);

        if ($usuario !== null) {
            $hashedInput = hash('sha256', $pass);
            $isValid = ($hashedInput === $usuario['contrasena']) || password_verify($pass, $usuario['contrasena']);

            if ($isValid) {
                // Format user record compatible with legacy session array structure
                $userData = [
                    'id_usuario'       => $usuario['id_usuario'],
                    'nombre'           => $usuario['nombre'],
                    'apellidos'        => $usuario['apellidos'],
                    'identificacion'   => $usuario['identificacion'],
                    'correo'           => $usuario['correo'],
                    'usuario'          => $usuario['usuario'],
                    'id_rol'           => [
                        'id_rol' => (int)$usuario['id_rol'],
                        'nombre' => $usuario['rol_nombre']
                    ],
                    'cod_progra_power' => $usuario['cod_progra_power']
                ];

                session_regenerate_id(true);
                Session::setUser($userData);

                if ((int)$usuario['id_rol'] === 2) {
                    Session::set('programa', [$userData]);
                }

                echo 'Datos Ingresados Correctos';
                exit;
            }
        }

        http_response_code(401);
        echo 'Credenciales incorrectas';
        exit;
    }

    public function autorizar(): void
    {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
            return;
        }

        $roleId = Session::roleId();

        match ($roleId) {
            1 => $this->redirect('/inicio/admin'),
            2 => $this->redirect('/inicio/departamento'),
            3 => $this->redirect('/inicio/logistica'),
            4 => $this->redirect('/inicio/financiera'),
            default => $this->redirect('/login'),
        };
    }

    public function logout(): void
    {
        Session::destroy();
        $this->redirect('/login');
    }
}
