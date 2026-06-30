<?php

namespace app\Models;

use app\Core\Database;
use PDO;

class Book {
    public static function all() {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM books ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public static function create($uploader_id, $title, $total_pages, $pdf_path, $cover_image = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO books (uploader_id, title, total_pages, pdf_path, cover_image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$uploader_id, $title, $total_pages, $pdf_path, $cover_image]);
        return $db->lastInsertId();
    }

    public static function findById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM books WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
