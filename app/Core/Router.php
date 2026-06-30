<?php

namespace app\Core;

class Router {
    protected array $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(Request $request, Response $response) {
        $method = $request->getMethod();
        $uri = $request->getUri();
        
        $routes = $this->routes[$method] ?? [];
        $callback = false;

        foreach ($routes as $route => $handler) {
            // Convert route with {param} to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
            $pattern = "@^" . $pattern . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                $callback = $handler;
                
                // Extract params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $request->setRouteParams($params);
                break;
            }
        }

        if ($callback === false) {
            $response->setStatusCode(404);
            echo View::renderError(404);
            return;
        }

        if (is_string($callback)) {
            echo View::render($callback);
            return;
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            $callback[0] = $controller;
        }

        echo call_user_func($callback, $request, $response);
    }
}
