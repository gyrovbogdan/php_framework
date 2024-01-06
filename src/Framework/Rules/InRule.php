<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class InRule implements RuleInterface
{
    function validate(array $data, string $field, array $params): bool
    {
        if (empty($params))
            throw new InvalidArgumentException('Params are empty');

        return in_array($data[$field], $params);
    }
    function getMessage(array $data, string $field, array $params): string
    {
        return "Invalid selection.";
    }
}
