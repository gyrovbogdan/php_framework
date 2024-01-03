<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

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

    public function dispatch(string $path, string $method, Container $container = null): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path)
                || $route['method'] !== $method
            ) continue;
            else {
                [$class, $function] = $route['controller'];

                $controllerInstance = $container ?
                    $container->resolve($class) :
                    new $class;

                $dispatchAction = fn () => $controllerInstance->$function();

                foreach ($this->middlewares as $middleware) {
                    $middlewareInstanse = $container ?
                        $container->resolve($middleware) :
                        new $middleware;

                    $dispatchAction = fn ()
                    => $middlewareInstanse->process($dispatchAction);
                }
                $dispatchAction();
            }
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
