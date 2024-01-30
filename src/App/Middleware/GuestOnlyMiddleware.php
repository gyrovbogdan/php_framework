<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class GuestOnlyMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (!isset($_SESSION['user']))
            $next();
        else
            redirectTo('/');
    }
}
