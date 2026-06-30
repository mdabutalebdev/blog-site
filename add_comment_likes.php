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
    $pdo->exec("CREATE TABLE IF NOT EXISTS comment_likes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        comment_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY user_comment_unique (user_id, comment_id),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
    )");
    
    // Check if like_count column exists in comments
    $res = $pdo->query("SHOW COLUMNS FROM comments LIKE 'like_count'");
    if ($res->rowCount() == 0) {
        $pdo->exec("ALTER TABLE comments ADD COLUMN like_count INT DEFAULT 0 AFTER content");
        echo "Column like_count added.\n";
    }

    echo "Table comment_likes ready.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
