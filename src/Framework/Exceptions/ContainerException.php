<?php

namespace Framework\Exceptions;

use Exception;
use Throwable;

class ContainerException extends Exception
{
    public function __construct(string $message, int $code = 0, Throwable $previos = null)
    {
        parent::__construct($message, $code, $previos);
    }
}
