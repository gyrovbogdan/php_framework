<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MatchRule implements RuleInterface
{
    function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params[0]))
            throw new InvalidArgumentException("Nothing to match.");

        $firstValue = $formData[$field];
        $secondValue = $formData[$params[0]];

        return $firstValue === $secondValue;
    }

    function getMessage(array $formData, string $field, array $params): string
    {
        return 'Fields are not match.';
    }
}
