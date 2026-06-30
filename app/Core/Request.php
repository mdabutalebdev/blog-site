<?php

namespace app\Core;

class Request {
    protected array $routeParams = [];

    public function getMethod(): string {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function getUri(): string {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        // Strip query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        
        // Remove base directory if needed (depending on local setup)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }

        return $uri === '' ? '/' : $uri;
    }

    public function getBody(): array {
        $body = [];
        if ($this->getMethod() === 'GET') {
            $body = $_GET;
        }
        if ($this->getMethod() === 'POST') {
            $body = $_POST;
        }
        return $body;
    }

    public function input($key, $default = null) {
        $body = $this->getBody();
        return $body[$key] ?? $default;
    }

    public function setRouteParams(array $params) {
        $this->routeParams = $params;
        return $this;
    }

    public function routeParam($key, $default = null) {
        return $this->routeParams[$key] ?? $default;
    }
}
