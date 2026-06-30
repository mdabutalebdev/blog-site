<?php

namespace app\Core;

class View {
    public static function render(string $view, array $params = []) {
        $layoutContent = self::layoutContent();
        $viewContent = self::renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public static function renderError(int $code) {
        return self::render("errors/$code");
    }

    protected static function layoutContent() {
        ob_start();
        require_once APP_ROOT . '/app/Views/layouts/MainLayout.php';
        return ob_get_clean();
    }

    protected static function renderOnlyView(string $view, array $params) {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        $viewPath = APP_ROOT . "/app/Views/$view.php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View not found: $view";
        }
        return ob_get_clean();
    }
}
