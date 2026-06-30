<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Models\Like;

class LikeController {
    public function toggle(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $post_id = $body['post_id'] ?? null;

        if (!$post_id) {
            $response->json(['error' => 'Post ID required'], 400);
        }

        $result = Like::toggle($post_id, $_SESSION['user_id']);
        
        $response->json(['success' => true, 'status' => $result['status']]);
    }
}
