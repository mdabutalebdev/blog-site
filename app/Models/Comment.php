<?php

namespace app\Models;

use app\Core\Database;
use PDO;

class Comment {
    public static function getByPostId($post_id) {
        $db = Database::getInstance();
        $user_id = $_SESSION['user_id'] ?? 0;
        $stmt = $db->prepare("
            SELECT comments.*, users.name as user_name, users.avatar as user_avatar,
                   (SELECT COUNT(*) FROM comment_likes WHERE comment_id = comments.id) as like_count,
                   (SELECT COUNT(*) FROM comment_likes WHERE comment_id = comments.id AND user_id = ?) as user_has_liked
            FROM comments 
            JOIN users ON comments.user_id = users.id 
            WHERE post_id = ? 
            ORDER BY created_at ASC
        ");
        $stmt->execute([$user_id, $post_id]);
        return $stmt->fetchAll();
    }

    public static function create($post_id, $user_id, $content, $parent_id = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, content, parent_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$post_id, $user_id, $content, $parent_id]);
        return $db->lastInsertId();
    }

    public static function toggleLike($comment_id, $user_id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM comment_likes WHERE comment_id = ? AND user_id = ?");
        $stmt->execute([$comment_id, $user_id]);
        $like = $stmt->fetch();

        if ($like) {
            $db->prepare("DELETE FROM comment_likes WHERE comment_id = ? AND user_id = ?")->execute([$comment_id, $user_id]);
            $db->prepare("UPDATE comments SET like_count = like_count - 1 WHERE id = ?")->execute([$comment_id]);
            return ['status' => 'unliked'];
        } else {
            $db->prepare("INSERT INTO comment_likes (comment_id, user_id) VALUES (?, ?)")->execute([$comment_id, $user_id]);
            $db->prepare("UPDATE comments SET like_count = like_count + 1 WHERE id = ?")->execute([$comment_id]);
            return ['status' => 'liked'];
        }
    }
}
