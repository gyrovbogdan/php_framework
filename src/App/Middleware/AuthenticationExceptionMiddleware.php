<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use App\Exceptions\AuthenticationException;

class AuthenticationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (AuthenticationException $e) {
            $oldFormData = $_POST;

            unset($oldFormData['password']);

            $_SESSION['oldFormData'] = $oldFormData;
            $_SESSION['message'] = $e->message;

            $referer = $_SERVER['HTTP_REFERER'];
            redirectTo($referer);
        }
    }
}
