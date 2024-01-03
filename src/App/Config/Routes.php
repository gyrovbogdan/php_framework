<?php

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController};

function registerRoutes(App $app)
{
    $app->get('/', [HomeController::class, 'home']);
    $app->get('/about', [AboutController::class, 'about']);
    $app->get('/test', [HomeController::class, 'test']);
}
