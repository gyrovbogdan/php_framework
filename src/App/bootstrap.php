<?php

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use Framework\HomeController;

$app = new App;

$app->run();

$app->get('/', [HomeController::class, 'home']);

return $app;
