<?php
declare(strict_types=1);

namespace App\Core;

class App
{
    private Router $router;
    private Request $request;

    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', getenv('SIPA_DEBUG') === '1' ? '1' : '0');
        ini_set('log_errors', '1');

        Session::start();
        View::init();

        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        // Default root redirects to login or user home
        $this->router->get('/', function(Request $req) {
            if (Session::isLoggedIn()) {
                $roleId = Session::roleId();
                $home = match ($roleId) {
                    1 => '/inicio/admin',
                    2 => '/inicio/departamento',
                    3 => '/inicio/logistica',
                    4 => '/inicio/financiera',
                    default => '/login',
                };
                header("Location: " . View::url($home));
                exit;
            }
            header("Location: " . View::url('/login'));
            exit;
        });

        // Auth routes
        $this->router->get('/login', [\App\Modules\Auth\AuthController::class, 'index']);
        $this->router->post('/login/autenticar', [\App\Modules\Auth\AuthController::class, 'autenticar']);
        $this->router->any('/autorizar', [\App\Modules\Auth\AuthController::class, 'autorizar']);
        $this->router->any('/autorizar/index', [\App\Modules\Auth\AuthController::class, 'autorizar']);
        $this->router->any('/logout', [\App\Modules\Auth\AuthController::class, 'logout']);

        // Home routes
        $this->router->get('/inicio/admin', [\App\Modules\Admin\AdminController::class, 'admin']);
        $this->router->get('/inicio/departamento', [\App\Modules\Practicas\PracticasController::class, 'indexAction']);
        $this->router->get('/inicio/logistica', [\App\Modules\Logistica\LogisticaController::class, 'index']);
        $this->router->get('/inicio/financiera', [\App\Modules\Financiera\FinancieraController::class, 'index']);
    }

    public function run(): void
    {
        $this->router->dispatch();
    }
}
