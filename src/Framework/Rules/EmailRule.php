<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class EmailRule implements RuleInterface
{
    function validate(array $formData, string $field, array $params): bool
    {
        return (bool) filter_var($formData[$field], FILTER_VALIDATE_EMAIL);
    }
    function getMessage(array $formData, string $field, array $params): string
    {
        return 'Invalid email.';
    }
}
