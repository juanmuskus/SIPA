<?php
declare(strict_types=1);

namespace App\Core;

use Exception;

class View
{
    private static string $viewsPath = '';
    private static string $baseUri = '';

    public static function init(): void
    {
        self::$viewsPath = dirname(__DIR__) . '/Views';
        self::$baseUri = Request::basePath();
    }

    public static function baseUri(): string
    {
        if (empty(self::$viewsPath)) {
            self::init();
        }
        return self::$baseUri;
    }

    public static function url(string $path = ''): string
    {
        $base = self::baseUri();
        $path = '/' . ltrim($path, '/');
        return $base . $path;
    }

    public static function asset(string $path): string
    {
        $scriptFile = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
        $isPublicDocumentRoot = str_ends_with(strtolower($scriptFile), '/public/index.php');
        $assetBase = $isPublicDocumentRoot ? '' : '/public';

        return self::url($assetBase . '/' . ltrim($path, '/'));
    }

    public static function escape(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    public static function render(string $viewPath, array $data = [], ?string $layout = 'admin'): string
    {
        if (empty(self::$viewsPath)) {
            self::init();
        }

        $fullViewFile = self::$viewsPath . '/' . ltrim($viewPath, '/') . '.php';
        if (!file_exists($fullViewFile)) {
            throw new Exception("View file not found: {$fullViewFile}");
        }

        // Extract variables to local scope
        extract($data);

        // Helper closures
        $url = fn(string $p = '') => self::url($p);
        $asset = fn(string $p) => self::asset($p);
        $e = fn(mixed $v) => self::escape($v);
        $user = Session::user();
        $roleId = Session::roleId();
        $roleName = Session::roleName();

        // Render view content into buffer
        ob_start();
        include $fullViewFile;
        $content = ob_get_clean();

        // If no layout is requested, return content directly
        if ($layout === null || $layout === 'none') {
            return $content;
        }

        // Render layout
        $layoutFile = self::$viewsPath . '/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new Exception("Layout file not found: {$layoutFile}");
        }

        ob_start();
        include $layoutFile;
        return ob_get_clean();
    }
}
