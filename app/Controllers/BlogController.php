<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\View;
use app\Models\Post;

class BlogController {
    public function index(Request $request, Response $response) {
        $posts = Post::all();
        return View::render('blog/index', ['posts' => $posts]);
    }
}
