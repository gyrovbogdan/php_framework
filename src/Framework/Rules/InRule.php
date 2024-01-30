<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class InRule implements RuleInterface
{
    function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params))
            throw new InvalidArgumentException('Params are empty');

        return in_array($formData[$field], $params);
    }
    function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid selection.";
    }
}
