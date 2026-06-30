<?php

use app\Controllers\HomeController;
use app\Controllers\AuthController;

/** @var \app\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

// Auth Routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'processLogin']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'processRegister']);
$router->get('/logout', [AuthController::class, 'logout']);

// Profile Routes
$router->get('/profile', [\app\Controllers\ProfileController::class, 'edit']);
$router->post('/profile', [\app\Controllers\ProfileController::class, 'update']);



$router->get('/category/{slug}', [HomeController::class, 'index']);

// Post Routes
$router->get('/my-blogs', [\app\Controllers\PostController::class, 'myBlogs']);
$router->get('/post/create', [\app\Controllers\PostController::class, 'create']);
$router->post('/post/store', [\app\Controllers\PostController::class, 'store']);
$router->get('/post/edit/{id}', [\app\Controllers\PostController::class, 'edit']);
$router->post('/post/update/{id}', [\app\Controllers\PostController::class, 'update']);
$router->post('/post/delete/{id}', [\app\Controllers\PostController::class, 'delete']);
$router->get('/post/{slug}', [\app\Controllers\PostController::class, 'show']);

// AJAX Routes
$router->post('/api/like', [\app\Controllers\LikeController::class, 'toggle']);
$router->get('/api/comments', [\app\Controllers\CommentController::class, 'index']);
$router->post('/api/comments', [\app\Controllers\CommentController::class, 'store']);
$router->post('/api/comments/like', [\app\Controllers\CommentController::class, 'toggleLike']);

// Book Routes
$router->get('/books', [\app\Controllers\BookController::class, 'index']);
$router->get('/books/upload', [\app\Controllers\BookController::class, 'upload']);
$router->post('/books/store', [\app\Controllers\BookController::class, 'store']);
$router->get('/books/view', [\app\Controllers\BookController::class, 'serve']);
