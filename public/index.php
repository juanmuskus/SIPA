<?php
declare(strict_types=1);

/**
 * SIPA - Sistema de Prácticas Académicas
 * PHP 8.x Pure Application Entry Point
 */

// Load the application autoloader
require_once dirname(__DIR__) . '/app/autoload.php';

// Bootstrap and run the application
$app = new \App\Core\App();
$app->run();