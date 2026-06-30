<?php
define('APP_ROOT', __DIR__);
require_once __DIR__ . '/config/database.php';
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db   = $_ENV['DB_NAME'] ?? 'amr_blog';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $res = $pdo->query("SHOW COLUMNS FROM users LIKE 'bio'");
    if ($res->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN bio TEXT NULL AFTER email");
        echo "Column bio added.\n";
    } else {
        echo "Column bio already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
