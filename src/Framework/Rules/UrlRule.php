<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class UrlRule implements RuleInterface
{
    function validate(array $data, string $field, array $params): bool
    {
        return (bool) filter_var($data[$field], FILTER_VALIDATE_URL);
    }
    function getMessage(array $data, string $field, array $params): string
    {
        return "Invalid url.";
    }
}
