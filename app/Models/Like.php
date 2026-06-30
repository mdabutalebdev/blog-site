<?php

namespace app\Models;

use app\Core\Database;
use PDO;

class Like {
    public static function toggle($post_id, $user_id) {
        $db = Database::getInstance();
        
        // Check if exists
        $stmt = $db->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $like = $stmt->fetch();

        if ($like) {
            // Unlike
            $stmt = $db->prepare("DELETE FROM likes WHERE id = ?");
            $stmt->execute([$like['id']]);
            return ['status' => 'unliked'];
        } else {
            // Like
            $stmt = $db->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
            $stmt->execute([$post_id, $user_id]);
            return ['status' => 'liked'];
        }
    }

    public static function isLikedBy($post_id, $user_id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ? LIMIT 1");
        $stmt->execute([$post_id, $user_id]);
        return (bool) $stmt->fetch();
    }
}
