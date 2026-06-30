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
    $pdo->exec("ALTER TABLE comments ADD COLUMN parent_id INT NULL DEFAULT NULL AFTER user_id;");
    $pdo->exec("ALTER TABLE comments ADD CONSTRAINT fk_comment_parent FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE;");
    echo "Column added.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
