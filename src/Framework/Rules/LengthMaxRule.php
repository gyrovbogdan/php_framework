<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LengthMaxRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        if (count($params) !== 1)
            throw new InvalidArgumentException('Maximum length not specified');

        return strlen($formData[$field]) <= $params[0];
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Max length is $params[0] characters.";
    }
}
