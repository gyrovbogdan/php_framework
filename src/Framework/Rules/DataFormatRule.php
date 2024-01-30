<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use DateTime;

class DataFormatRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        return (bool) DateTime::createFromFormat('Y-m-d', $formData[$field]);
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return 'Wrong date format';
    }
}
