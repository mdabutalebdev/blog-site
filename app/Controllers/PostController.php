<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\View;
use app\Models\Post;

class PostController {
    public function create(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->redirect('/login');
        }
        return View::render('blog/create');
    }

    public function store(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->json(['error' => 'Unauthorized'], 401);
        }

        $title = $request->input('title');
        $content = $request->input('content'); 
        $category = $request->input('category');
        
        if (empty($title) || empty($content)) {
            $response->json(['error' => 'Title and content are required'], 400);
        }

        // Handle cover image upload
        $cover_image_path = null;
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = APP_ROOT . '/public/uploads/covers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = uniqid('cover_') . '_' . basename($_FILES['cover_image']['name']);
            // Very basic sanitize
            $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
            
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $filename)) {
                $cover_image_path = '/uploads/covers/' . $filename;
            }
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))) . '-' . uniqid();
        
        try {
            $postId = Post::create($_SESSION['user_id'], $title, $slug, $content, $cover_image_path, $category);
            $response->json(['success' => true, 'redirect' => '/']);
        } catch (\PDOException $e) {
            // Check if it's a packet size error
            if (strpos($e->getMessage(), 'max_allowed_packet') !== false) {
                $response->json(['error' => 'The post content is too large. If you inserted large images, please resize them.'], 400);
            }
            $response->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            $response->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Request $request, Response $response) {
        $slug = $request->routeParam('slug');
        $post = Post::findBySlug($slug);
        
        if (!$post) {
            $response->setStatusCode(404);
            return View::renderError(404);
        }
        
        // 1. Generate TOC and inject IDs into headings
        $toc = [];
        $content = $post['content'];
        
        // Increase PCRE limits for large posts
        ini_set('pcre.backtrack_limit', '100000000');
        ini_set('pcre.recursion_limit', '100000000');
        
        $contentWithIds = preg_replace_callback('/<(h[23])>(.*?)<\/\1>/is', function($matches) use (&$toc) {
            $tag = strtolower($matches[1]);
            $text = strip_tags($matches[2]);
            // Generate a safe ID
            $id = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
            
            $toc[] = [
                'tag' => $tag, // 'h2' or 'h3'
                'text' => $text,
                'id' => $id
            ];
            
            return "<{$matches[1]} id=\"{$id}\">{$matches[2]}</{$matches[1]}>";
        }, $content);
        
        if ($contentWithIds !== null) {
            $post['content'] = $contentWithIds; // Override with injected IDs
        }
        
        // 2. Fetch Related Posts (same category, exclude current)
        $relatedPosts = [];
        if (!empty($post['category'])) {
            $relatedPosts = Post::getRelatedPosts($post['category'], $post['id'], 5);
        }

        return View::render('blog/show', [
            'post' => $post,
            'toc' => $toc,
            'relatedPosts' => $relatedPosts
        ]);
    }

    public function myBlogs(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $posts = Post::getByUser($_SESSION['user_id']);
        return View::render('blog/my_blogs', ['posts' => $posts]);
    }

    public function edit(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $id = $request->routeParam('id');
        $post = Post::findById($id);
        if (!$post || $post['author_id'] != $_SESSION['user_id']) {
            $response->setStatusCode(404);
            return View::renderError(404);
        }
        return View::render('blog/edit', ['post' => $post]);
    }

    public function update(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->json(['error' => 'Unauthorized'], 401);
        }
        $id = $request->routeParam('id');
        $post = Post::findById($id);
        if (!$post || $post['author_id'] != $_SESSION['user_id']) {
            $response->json(['error' => 'Not found or unauthorized'], 404);
        }

        $title = $request->input('title');
        $content = $request->input('content');
        $category = $request->input('category');

        $cover_image_path = $post['cover_image']; // keep existing
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = APP_ROOT . '/public/uploads/covers/';
            $filename = uniqid('cover_') . '_' . basename($_FILES['cover_image']['name']);
            $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $filename);
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadDir . $filename)) {
                $cover_image_path = '/uploads/covers/' . $filename;
            }
        }

        Post::update($id, $title, $content, $cover_image_path, $category);
        $response->json(['success' => true, 'redirect' => '/my-blogs']);
    }

    public function delete(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->json(['error' => 'Unauthorized'], 401);
        }
        $id = $request->routeParam('id');
        $post = Post::findById($id);
        if (!$post || $post['author_id'] != $_SESSION['user_id']) {
            $response->json(['error' => 'Not found or unauthorized'], 404);
        }
        Post::delete($id);
        $response->json(['success' => true]);
    }
}
