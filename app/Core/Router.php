<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function any(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array|callable $handler): void
    {
        $normPath = '/' . trim(strtolower($path), '/');
        if ($normPath === '//') {
            $normPath = '/';
        }
        $this->routes[$method][$normPath] = $handler;
    }

    public function dispatch(): void
    {
        $method = $this->request->method();
        $path = $this->request->path();
        $normPath = '/' . trim(strtolower($path), '/');
        if ($normPath === '//') {
            $normPath = '/';
        }

        // 1. Direct route match
        if (isset($this->routes[$method][$normPath])) {
            $this->executeHandler($this->routes[$method][$normPath]);
            return;
        }

        // Check fallback for any method if registered
        if ($method === 'POST' && isset($this->routes['GET'][$normPath])) {
            $this->executeHandler($this->routes['GET'][$normPath]);
            return;
        }

        // 2. Dynamic /{controller}/{action} mapping
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));
        if (!empty($segments)) {
            $controllerName = strtolower($segments[0]);
            $actionName = isset($segments[1]) ? strtolower($segments[1]) : 'index';

            $controllerClass = $this->resolveControllerClass($controllerName);
            if ($controllerClass !== null) {
                $controllerInstance = new $controllerClass($this->request);
                
                // Find matching method in controller (e.g., actionName, actionNameAction, index)
                $methodToCall = $this->resolveActionMethod($controllerInstance, $actionName);
                if ($methodToCall !== null) {
                    $controllerInstance->$methodToCall();
                    return;
                }
            }
        }

        // 404 Not Found
        $this->handleNotFound($path);
    }

    private function executeHandler(array|callable $handler): void
    {
        if (is_callable($handler)) {
            $handler($this->request);
            return;
        }

        [$class, $method] = $handler;
        $controller = new $class($this->request);
        $controller->$method();
    }

    private function resolveControllerClass(string $name): ?string
    {
        // Map common controller names to their modern module classes
        $map = [
            'login'            => \App\Modules\Auth\AuthController::class,
            'logout'           => \App\Modules\Auth\AuthController::class,
            'autorizar'        => \App\Modules\Auth\AuthController::class,
            'inicio'           => \App\Modules\Admin\AdminController::class,
            'usuarios'         => \App\Modules\Admin\UsuariosController::class,
            'calendar'         => \App\Modules\Admin\CalendarioController::class,
            'calendario'       => \App\Modules\Admin\CalendarioController::class,
            'rutas'            => \App\Modules\Admin\RutasController::class,
            'recurespeciales'  => \App\Modules\Admin\RecursosController::class,
            'practicas'        => \App\Modules\Practicas\PracticasController::class,
            'programacion'     => \App\Modules\Practicas\ProgramacionController::class,
            'progrecurso'      => \App\Modules\Practicas\ProgrecursoController::class,
            'participantes'    => \App\Modules\Practicas\ParticipantesController::class,
            'conductor'        => \App\Modules\Logistica\ConductorController::class,
            'transporte'       => \App\Modules\Logistica\VehiculoController::class,
            'servicio'         => \App\Modules\Logistica\ServicioController::class,
            'liquiconductor'   => \App\Modules\Logistica\LiquidacionConductorController::class,
            'liquidarpracticas'=> \App\Modules\Financiera\PagoPracticaController::class,
            'logistica'        => \App\Modules\Logistica\LogisticaController::class,
            'financiera'       => \App\Modules\Financiera\FinancieraController::class,
        ];

        return $map[$name] ?? null;
    }

    private function resolveActionMethod(object $controller, string $actionName): ?string
    {
        // Look for exact method or method with 'Action' suffix
        $candidates = [
            $actionName,
            $actionName . 'Action',
            lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $actionName)))),
            lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $actionName)))) . 'Action',
        ];

        foreach ($candidates as $cand) {
            if (method_exists($controller, $cand)) {
                return $cand;
            }
        }

        return null;
    }

    private function handleNotFound(string $path): void
    {
        http_response_code(404);
        if ($this->request->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Ruta no encontrada: ' . $path]);
            exit;
        }

        echo View::render('errors/404', ['path' => $path], null);
        exit;
    }
}
