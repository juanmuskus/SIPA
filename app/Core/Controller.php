<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function render(string $view, array $data = [], ?string $layout = 'admin'): void
    {
        echo View::render($view, $data, $layout);
    }

    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function redirect(string $url): void
    {
        $finalUrl = str_starts_with($url, 'http') ? $url : View::url($url);
        header("Location: {$finalUrl}");
        exit;
    }

    protected function requireAuth(array $allowedRoles = []): void
    {
        if (!Session::isLoggedIn()) {
            if ($this->request->isAjax()) {
                $this->json(['error' => 'No autorizado'], 401);
            }
            $this->redirect('/login');
        }

        if (!empty($allowedRoles)) {
            $userRole = Session::roleId();
            if ($userRole === null || !in_array($userRole, $allowedRoles, true)) {
                if ($this->request->isAjax()) {
                    $this->json(['error' => 'Acceso denegado'], 403);
                }
                // Redirect to their default home
                match ($userRole) {
                    1 => $this->redirect('/inicio/admin'),
                    2 => $this->redirect('/inicio/departamento'),
                    3 => $this->redirect('/inicio/logistica'),
                    4 => $this->redirect('/inicio/financiera'),
                    default => $this->redirect('/login'),
                };
            }
        }
    }

    protected function param(string $key, mixed $default = null): mixed
    {
        return $this->request->param($key, $default);
    }

    protected function getParam(string $key, mixed $default = null): mixed
    {
        return $this->param($key, $default);
    }
}
