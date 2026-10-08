<?php
declare(strict_types=1);

namespace App\Core;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private ?array $json = null;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;

        $contentType = $this->server['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $input = file_get_contents('php://input');
            $this->json = json_decode($input, true) ?: [];
        }
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }

    public function isAjax(): bool
    {
        return (!empty($this->server['HTTP_X_REQUESTED_WITH']) &&
                strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public static function basePath(): string
    {
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $basePath = str_replace('\\', '/', dirname($scriptName));
        $basePath = $basePath === '.' || $basePath === '/' ? '' : $basePath;

        if (str_ends_with(strtolower($basePath), '/public')) {
            $basePath = substr($basePath, 0, -strlen('/public'));
        }

        return rtrim($basePath, '/');
    }

    public function path(): string
    {
        $uri = parse_url($this->uri(), PHP_URL_PATH) ?? '/';

        $baseDir = self::basePath();

        if ($baseDir !== '' && $baseDir !== '/' &&
            (strcasecmp($uri, $baseDir) === 0 ||
                strncasecmp($uri, $baseDir . '/', strlen($baseDir) + 1) === 0)) {
            $uri = substr($uri, strlen($baseDir));
        }

        $uri = '/' . ltrim($uri, '/');
        return $uri;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        if ($this->json !== null && array_key_exists($key, $this->json)) {
            return $this->json[$key];
        }
        return $this->post[$key] ?? $default;
    }

    public function param(string $key, mixed $default = null): mixed
    {
        if ($this->post($key) !== null) {
            return $this->post($key);
        }
        if ($this->get($key) !== null) {
            return $this->get($key);
        }
        return $default;
    }

    public function all(): array
    {
        $data = array_merge($this->get, $this->post);
        if ($this->json !== null) {
            $data = array_merge($data, $this->json);
        }
        return $data;
    }
}
