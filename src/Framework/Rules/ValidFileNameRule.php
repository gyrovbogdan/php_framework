<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class ValidFileNameRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9,._=+\- ]+$/', $formData[$field]);
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid file name.";
    }
}
