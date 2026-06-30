<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Models\User;
use app\Core\Database;
use app\Core\View;

class ProfileController {
    public function edit(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $user = User::findById($_SESSION['user_id']);
        return View::render('profile/edit', ['user' => $user]);
    }

    public function update(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $bio = $request->input('bio');
        $password = $request->input('password');

        $db = Database::getInstance();
        $user_id = $_SESSION['user_id'];
        $user = User::findById($user_id);

        $errors = [];

        // Handle Avatar Upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = APP_ROOT . '/public/uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileInfo = pathinfo($_FILES['avatar']['name']);
            $ext = strtolower($fileInfo['extension']);
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($ext, $allowedExts)) {
                $filename = uniqid('avatar_') . '.' . $ext;
                $destination = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                    $avatarPath = '/uploads/avatars/' . $filename;
                    $db->prepare("UPDATE users SET avatar = ? WHERE id = ?")->execute([$avatarPath, $user_id]);
                    $_SESSION['user_avatar'] = $avatarPath;
                } else {
                    $errors[] = "Failed to upload avatar.";
                }
            } else {
                $errors[] = "Invalid image format.";
            }
        }

        // Update basic info
        if ($name && $email) {
            $db->prepare("UPDATE users SET name = ?, email = ?, bio = ? WHERE id = ?")->execute([$name, $email, $bio, $user_id]);
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
        }

        // Update password if provided
        if (!empty($password)) {
            $password_confirmation = $request->input('password_confirmation');
            if ($password !== $password_confirmation) {
                $errors[] = "Passwords do not match.";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?")->execute([$hashed, $user_id]);
            }
        }

        if (empty($errors)) {
            header("Location: /profile?success=1");
            exit;
        } else {
            return View::render('profile/edit', ['user' => $user, 'errors' => $errors]);
        }
    }
}
