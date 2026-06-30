<?php
define('APP_ROOT', __DIR__);
require_once __DIR__ . '/config/database.php';

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db   = $_ENV['DB_NAME'] ?? 'amr_blog';

try {
    // Connect without DB name to create the database
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Creating database...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
    $pdo->exec("USE `$db`");

    echo "Running schema...\n";
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $pdo->exec($schema);

    echo "Running seed...\n";
    // First, check if users table is empty to avoid duplicate seeding
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $seed = file_get_contents(__DIR__ . '/database/seed.sql');
        $pdo->exec($seed);
        echo "Seed data inserted.\n";
    } else {
        echo "Database already seeded.\n";
    }
    
    echo "Setup complete!\n";

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    echo "Ensure MySQL is running and credentials in .env are correct.\n";
}
