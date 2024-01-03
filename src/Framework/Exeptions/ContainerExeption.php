<?php

namespace Framework\Exeptions;

use Exception;
use Throwable;

class ContainerExeption extends Exception
{

    public function __construct(string $message, int $code = 0, Throwable $previos = null)
    {
        parent::__construct($message, $code, $previos);
    }
}
