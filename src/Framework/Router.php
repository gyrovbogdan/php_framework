<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    private array $errorHandler;

    public function add(string $path, string $method, array $controller)
    {
        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller' => $controller,
            'regexPath' => $regexPath
        ];
        return $this;
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        return strlen($path) === 0 ?  '/' : "/$path/";
    }

    public function dispatch(string $path, string $method, Container $container = null): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$this->normalizePath($route['regexPath'])}$#", $path, $paramValues)
                || $route['method'] !== $method
            ) continue;
            else {
                [$class, $function] = $route['controller'];

                $controllerInstance = $container ?
                    $container->resolve($class) :
                    new $class;

                array_shift($paramValues);

                preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys);
                array_shift($paramKeys);

                $paramKeys = $paramKeys[0];
                $params = array_combine($paramKeys, $paramValues);

                $dispatchAction = fn () => $controllerInstance->{$function}($params);

                $allMiddleware = [...$route['middleware'] ?? [], ...$this->middlewares];

                foreach ($allMiddleware as $middleware) {
                    $middlewareInstanse = $container ?
                        $container->resolve($middleware) :
                        new $middleware;

                    $dispatchAction = fn ()
                    => $middlewareInstanse->process($dispatchAction);
                }
                $dispatchAction();
                return;
            }
        }

        $this->dispatchErrorHandler($container);
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function addRouteMiddleware(string $middleware)
    {
        $router = array_key_last($this->routes);
        $this->routes[$router]['middleware'][] = $middleware;
    }

    public function dispatchErrorHandler(Container $container = NULL)
    {
        [$class, $function] = $this->errorHandler;

        $controllerInstance = $container ?
            $container->resolve($class) :
            new $class;

        $dispatchAction = fn () => $controllerInstance->{$function}();

        $allMiddleware = $this->middlewares;

        foreach ($allMiddleware as $middleware) {
            $middlewareInstanse = $container ?
                $container->resolve($middleware) :
                new $middleware;

            $dispatchAction = fn ()
            => $middlewareInstanse->process($dispatchAction);
        }
        $dispatchAction();
    }

    public function addErrorHandler(array $controller)
    {
        $this->errorHandler = $controller;
    }
}
