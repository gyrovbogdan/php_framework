<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class CsrfGuardMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        $availableMethods = ['POST', 'PUT', 'DELETE'];
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        if (!in_array($method, $availableMethods)) {
            $next();
            return;
        }

        if ($_SERVER['CONTENT_LENGTH'] && !$_FILES && !$_POST) {
            redirectTo($_SERVER['REQUEST_URI']);
            throw new ValidationException(['receipt' => ['File exceeded upload max filesize.']]);
        }

        if ($_SESSION['token'] !== $_POST['token']) {
            redirectTo('/');
            return;
        }

        unset($_SESSION['token']);
        $next();
    }
}
