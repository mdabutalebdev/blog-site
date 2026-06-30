<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\View;
use app\Models\Book;

class BookController {
    public function index(Request $request, Response $response) {
        $books = Book::all();
        return View::render('books/index', ['books' => $books]);
    }

    public function upload(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->redirect('/login');
        }
        return View::render('books/upload');
    }

    public function store(Request $request, Response $response) {
        if (!isset($_SESSION['user_id'])) {
            $response->redirect('/login');
        }

        $title = $request->input('title');
        $total_pages = (int) $request->input('total_pages');
        
        if (empty($title) || $total_pages <= 0) {
            return View::render('books/upload', ['error' => 'Invalid title or pages']);
        }

        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            return View::render('books/upload', ['error' => 'Error uploading file']);
        }

        $file = $_FILES['pdf_file'];
        
        // Simple MIME type check
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if ($mime !== 'application/pdf') {
            return View::render('books/upload', ['error' => 'Only PDF files are allowed']);
        }

        $uploadDir = APP_ROOT . '/storage/books/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid('book_') . '.pdf';
        $destination = $uploadDir . $filename;

        // Handle Cover Image
        $cover_image_path = null;
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $coverDir = APP_ROOT . '/public/uploads/covers/';
            if (!is_dir($coverDir)) {
                mkdir($coverDir, 0755, true);
            }
            $cover_filename = uniqid('book_cover_') . '_' . basename($_FILES['cover_image']['name']);
            $cover_filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $cover_filename);
            
            if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $coverDir . $cover_filename)) {
                $cover_image_path = '/uploads/covers/' . $cover_filename;
            }
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Save to DB
            Book::create($_SESSION['user_id'], $title, $total_pages, $filename, $cover_image_path);
            $response->redirect('/books');
        } else {
            return View::render('books/upload', ['error' => 'Failed to save file']);
        }
    }

    public function serve(Request $request, Response $response) {
        $id = $request->input('id'); // we'll use a query param or route param. For now query param ?id=1
        
        if (!$id) {
            $response->setStatusCode(404);
            echo "Not found"; return;
        }

        $book = Book::findById($id);
        if (!$book) {
            $response->setStatusCode(404);
            echo "Not found"; return;
        }

        $path = APP_ROOT . '/storage/books/' . $book['pdf_path'];
        if (file_exists($path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($book['pdf_path']) . '"');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;
        } else {
            $response->setStatusCode(404);
            echo "File missing"; return;
        }
    }
}
