<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Models\Comment;

class CommentController {
    public function index(Request $request, Response $response) {
        $post_id = $request->input('post_id');
        if (!$post_id) {
            $response->json(['error' => 'Post ID required'], 400);
        }

        $all_comments = Comment::getByPostId($post_id);
        $comments = [];
        $replies = [];

        foreach ($all_comments as $c) {
            if (!empty($c['parent_id'])) {
                $replies[$c['parent_id']][] = $c;
            } else {
                $comments[] = $c;
            }
        }
        
        // Output raw HTML components for comments to simplify frontend rendering
        ob_start();
        if (empty($comments)) {
            echo '<div class="text-sm text-gray-500">No comments yet.</div>';
        } else {
            foreach ($comments as $comment) {
                $comment_replies = $replies[$comment['id']] ?? [];
                echo component('CommentItem', ['comment' => $comment, 'replies' => $comment_replies]);
            }
        }
        $html = ob_get_clean();

        $response->json(['success' => true, 'html' => $html]);
    }

    public function store(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $post_id = $body['post_id'] ?? null;
        $content = $body['content'] ?? null;
        $parent_id = $body['parent_id'] ?? null;

        if (!$post_id || !$content) {
            $response->json(['error' => 'Missing data'], 400);
        }

        $id = Comment::create($post_id, $_SESSION['user_id'], htmlspecialchars($content), $parent_id);
        $response->json(['success' => true]);
    }

    public function toggleLike(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->json(['error' => 'Unauthorized'], 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $comment_id = $body['comment_id'] ?? null;

        if (!$comment_id) {
            $response->json(['error' => 'Comment ID required'], 400);
        }

        $result = Comment::toggleLike($comment_id, $_SESSION['user_id']);
        $response->json(array_merge(['success' => true], $result));
    }
}
