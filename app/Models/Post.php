<?php

namespace app\Models;

use app\Core\Database;
use PDO;

class Post {
    public static function all() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            ORDER BY posts.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public static function create($author_id, $title, $slug, $content, $cover_image = null, $category = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO posts (author_id, title, slug, content, cover_image, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$author_id, $title, $slug, $content, $cover_image, $category]);
        return $db->lastInsertId();
    }

    public static function findBySlug($slug) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.slug = ? LIMIT 1
        ");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public static function getCategoriesWithCounts() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT category, COUNT(*) as count 
            FROM posts 
            WHERE category IS NOT NULL AND category != '' 
            GROUP BY category 
            ORDER BY count DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findByCategory($category) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.category = ?
            ORDER BY posts.created_at DESC
        ");
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public static function searchAndFilter($query = null, $category = null) {
        $db = Database::getInstance();
        $sql = "
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE 1=1
        ";
        $params = [];

        if (!empty($category)) {
            $sql .= " AND posts.category = ?";
            $params[] = $category;
        }

        if (!empty($query)) {
            $sql .= " AND (posts.title LIKE ? OR posts.content LIKE ? OR users.name LIKE ?)";
            $searchTerm = '%' . $query . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $sql .= " ORDER BY posts.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function getRelatedPosts($category, $excludeId, $limit = 4) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT id, title, slug
            FROM posts 
            WHERE category = ? AND id != ?
            ORDER BY created_at DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $category);
        $stmt->bindValue(2, $excludeId);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByUser($user_id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.author_id = ?
            ORDER BY posts.created_at DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function update($id, $title, $content, $cover_image, $category) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE posts SET title = ?, content = ?, cover_image = ?, category = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $cover_image, $category, $id]);
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
