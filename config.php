<?php

// Load .env variables
$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        if (strpos($line, '=') === false) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);

        $name = trim($name);
        $value = trim($value ?? '');

        if ($name !== '' && !array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

if (!defined('BASE_URL')) {
    $envBase = $_ENV['BASE_URL'] ?? '';
    if (!empty($envBase) && $envBase !== '/') {
        $base_url = rtrim($envBase, '/') . '/';
    } else {
        $docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
        $dir = str_replace('\\', '/', __DIR__);
        $relativePath = str_replace($docRoot, '', $dir);
        $base_url = '/' . trim($relativePath, '/') . '/';
        if ($base_url === '//') {
            $base_url = '/';
        }
    }
    define('BASE_URL', $base_url);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Disable mysqli exceptions (restore old behavior) to prevent early 500 errors
mysqli_report(MYSQLI_REPORT_OFF);

$host = !empty($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : "localhost";
$user = !empty($_ENV['DB_USER']) ? $_ENV['DB_USER'] : "root";
$password = $_ENV['DB_PASS'] ?? "";
$database = !empty($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : "new_spyder";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
