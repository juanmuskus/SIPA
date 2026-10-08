<?php
declare(strict_types=1);

$environmentValue = static function (string $name, string $default): string {
    $value = getenv($name);
    return $value === false ? $default : $value;
};

$connection = static function (string $name, string $database) use ($environmentValue): array {
    $prefix = 'SIPA_DB_' . strtoupper($name) . '_';
    $driver = strtolower($environmentValue($prefix . 'DRIVER', 'mysql'));

    return [
        'driver'   => $driver,
        'host'     => $environmentValue($prefix . 'HOST', 'localhost'),
        'port'     => (int)$environmentValue($prefix . 'PORT', $driver === 'sqlsrv' ? '1433' : '3306'),
        'database' => $environmentValue($prefix . 'NAME', $database),
        'username' => $environmentValue($prefix . 'USER', 'root'),
        'password' => $environmentValue($prefix . 'PASSWORD', ''),
        'charset'  => $environmentValue($prefix . 'CHARSET', 'utf8mb4'),
        'options'  => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
    ];
};

return [
    'practicas' => $connection('practicas', 'practicas'),
    'campus'    => $connection('campus', 'campus'),
    'kactus'    => $connection('kactus', 'kactus'),
];
