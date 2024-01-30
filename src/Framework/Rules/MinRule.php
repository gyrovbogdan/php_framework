<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MinRule implements RuleInterface
{
    function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params[0]))
            throw new InvalidArgumentException('Minimum length not specified');

        return $formData[$field] >= (int) $params[0];
    }
    function getMessage(array $formData, string $field, array $params): string
    {
        return "Field value must be greater then or equal $params[0].";
    }
}
