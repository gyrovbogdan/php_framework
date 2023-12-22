<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $path, $method, $controller)
    {
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller' => $controller
        ];
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        return strlen($path) === 0 ?  '/' : "/$path/";
    }

    public function dispatch(string $path, string $method): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        echo $path . $method;
    }
}
