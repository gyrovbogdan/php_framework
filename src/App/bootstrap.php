<?php

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};
use Dotenv\Dotenv;
use App\Config\Paths;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

$app = new App(Paths::SOURCE . '/App/container-definitions.php');

registerRoutes($app);
registerMiddleware($app);

$app->run();

return $app;
