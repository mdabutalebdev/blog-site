<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\View;
use app\Models\User;

class AuthController {
    public function showLogin(Request $request, Response $response) {
        return View::render('auth/login');
    }

    public function processLogin(Request $request, Response $response) {
        $email = $request->input('email');
        $password = $request->input('password');
        
        $user = User::findByEmail($email);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_avatar'] = $user['avatar'] ?? null;
            $response->redirect('/');
        }
        
        return View::render('auth/login', ['error' => 'Invalid email or password']);
    }

    public function showRegister(Request $request, Response $response) {
        return View::render('auth/register');
    }

    public function processRegister(Request $request, Response $response) {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirm = $request->input('password_confirmation');

        if ($password !== $confirm) {
            return View::render('auth/register', ['error' => 'Passwords do not match']);
        }

        // Check if email exists
        if (User::findByEmail($email)) {
            return View::render('auth/register', ['error' => 'Email already registered']);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $userId = User::create($name, $email, $hash);

        if ($userId) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $response->redirect('/');
        }
        
        return View::render('auth/register', ['error' => 'Registration failed']);
    }

    public function logout(Request $request, Response $response) {
        session_destroy();
        $response->redirect('/');
    }
}
