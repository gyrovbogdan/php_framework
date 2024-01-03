<?php

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use function App\Config\{registerRoutes, registerMiddleware};
use App\Config\Paths;


$app = new App(Paths::SOURCE . '/App/container-definitions.php');

registerRoutes($app);
registerMiddleware($app);

$app->run();


return $app;
