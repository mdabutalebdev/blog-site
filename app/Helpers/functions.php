<?php

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function asset($path) {
    return '/assets/' . ltrim($path, '/');
}

function component($name, $data = []) {
    $componentPath = APP_ROOT . "/app/Views/components/{$name}.php";
    if (file_exists($componentPath)) {
        extract($data);
        ob_start();
        require $componentPath;
        return ob_get_clean();
    }
    return '';
}

function slugify($text) {
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}
