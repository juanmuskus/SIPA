<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use Exception;

class Database
{
    private static array $instances = [];
    private static ?array $config = null;

    private static function loadConfig(): array
    {
        if (self::$config === null) {
            $configPath = dirname(__DIR__) . '/Config/database.php';
            if (!file_exists($configPath)) {
                throw new Exception("Configuration file not found: {$configPath}");
            }
            self::$config = require $configPath;
        }
        return self::$config;
    }

    public static function getConnection(string $name = 'practicas'): PDO
    {
        if (!isset(self::$instances[$name])) {
            $config = self::loadConfig();
            if (!isset($config[$name])) {
                throw new Exception("Database configuration for [{$name}] not defined.");
            }

            $dbConf = $config[$name];
            $dsn = match ($dbConf['driver']) {
                'mysql' => "{$dbConf['driver']}:host={$dbConf['host']};port={$dbConf['port']};dbname={$dbConf['database']};charset={$dbConf['charset']}",
                'sqlsrv' => "sqlsrv:Server={$dbConf['host']},{$dbConf['port']};Database={$dbConf['database']}",
                default => throw new \InvalidArgumentException("Unsupported database driver [{$dbConf['driver']}] for [{$name}]."),
            };
            
            self::$instances[$name] = new PDO(
                $dsn,
                $dbConf['username'],
                $dbConf['password'],
                $dbConf['options'] ?? []
            );
        }

        return self::$instances[$name];
    }

    public static function practicas(): PDO
    {
        return self::getConnection('practicas');
    }

    public static function campus(): PDO
    {
        return self::getConnection('campus');
    }

    public static function kactus(): PDO
    {
        return self::getConnection('kactus');
    }

    public static function query(string $sql, array $params = [], string $db = 'practicas'): \PDOStatement
    {
        $pdo = self::getConnection($db);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = [], string $db = 'practicas'): array
    {
        return self::query($sql, $params, $db)->fetchAll();
    }

    public static function fetch(string $sql, array $params = [], string $db = 'practicas'): ?array
    {
        $result = self::query($sql, $params, $db)->fetch();
        return $result ?: null;
    }

    public static function fetchColumn(string $sql, array $params = [], int $col = 0, string $db = 'practicas'): mixed
    {
        return self::query($sql, $params, $db)->fetchColumn($col);
    }

    public static function insert(string $table, array $data, string $db = 'practicas'): int
    {
        $pdo = self::getConnection($db);
        $fields = array_keys($data);
        $placeholders = array_map(fn($f) => ":{$f}", $fields);

        $sql = sprintf(
            "INSERT INTO `%s` (`%s`) VALUES (%s)",
            $table,
            implode('`, `', $fields),
            implode(', ', $placeholders)
        );

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        return (int)$pdo->lastInsertId();
    }

    public static function update(string $table, array $data, string $where, array $whereParams = [], string $db = 'practicas'): int
    {
        $pdo = self::getConnection($db);
        $sets = [];
        $params = [];

        foreach ($data as $key => $val) {
            $sets[] = "`{$key}` = :set_{$key}";
            $params["set_{$key}"] = $val;
        }

        $params = array_merge($params, $whereParams);
        $sql = sprintf("UPDATE `%s` SET %s WHERE %s", $table, implode(', ', $sets), $where);

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public static function delete(string $table, string $where, array $whereParams = [], string $db = 'practicas'): int
    {
        $pdo = self::getConnection($db);
        $sql = sprintf("DELETE FROM `%s` WHERE %s", $table, $where);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($whereParams);
        return $stmt->rowCount();
    }

    public static function beginTransaction(string $db = 'practicas'): void
    {
        self::getConnection($db)->beginTransaction();
    }

    public static function commit(string $db = 'practicas'): void
    {
        self::getConnection($db)->commit();
    }

    public static function rollBack(string $db = 'practicas'): void
    {
        if (isset(self::$instances[$db]) && self::$instances[$db]->inTransaction()) {
            self::$instances[$db]->rollBack();
        }
    }
}
