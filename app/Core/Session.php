<?php
declare(strict_types=1);

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function setUser(array $user): void
    {
        self::set('user', $user);
        // Also keep compatibility with legacy Zend_Auth structure if needed by JS or scripts
        self::set('Zend_Auth', ['usuarios' => [$user]]);
    }

    public static function user(): ?array
    {
        return self::get('user');
    }

    public static function roleId(): ?int
    {
        $user = self::user();
        if (!$user) {
            return null;
        }
        if (isset($user['id_rol'])) {
            return is_array($user['id_rol']) ? (int)($user['id_rol']['id_rol'] ?? 0) : (int)$user['id_rol'];
        }
        return null;
    }

    public static function roleName(): string
    {
        $roleId = self::roleId();
        return match ($roleId) {
            1 => 'Admin',
            2 => 'Departamento',
            3 => 'Logística',
            4 => 'Financiera',
            default => 'Invitado',
        };
    }

    public static function isLoggedIn(): bool
    {
        return self::user() !== null;
    }

    public static function setFlash(string $type, string $message): void
    {
        self::set("flash_{$type}", $message);
    }

    public static function getFlash(string $type): ?string
    {
        $msg = self::get("flash_{$type}");
        self::remove("flash_{$type}");
        return $msg;
    }
}
