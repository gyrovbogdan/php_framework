<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitionsPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitionsPath) {
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    public function get(string $path, array $controller): App
    {
        $this->router->add($path, "GET", $controller);
        return $this;
    }

    public function post(string $path, array $controller): App
    {
        $this->router->add($path, "POST", $controller);
        return $this;
    }

    public function put(string $path, array $controller): App
    {
        $this->router->add($path, "PUT", $controller);
        return $this;
    }

    public function delete(string $path, array $controller): App
    {
        $this->router->add($path, "DELETE", $controller);
        return $this;
    }

    function run(): void
    {
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $method = $_SERVER["REQUEST_METHOD"];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function addMiddleware(string $middleware)
    {
        $this->router->addMiddleware($middleware);
    }

    public function add(string $middleware)
    {
        $this->router->addRouteMiddleware($middleware);
    }

    public function addErrorHandler(array $controller)
    {
        $this->router->addErrorHandler($controller);
    }
}
