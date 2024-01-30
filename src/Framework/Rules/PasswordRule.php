<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class PasswordRule implements RuleInterface
{
    private array $rules = [
        '{8,}' => 'The password must be 8 characters or more.',
        '*[a-zA-Z]' =>  'The password must contain at least one letter(a-z or A-Z).',
        '*[0-9]' => 'The password must contain at least one digit(0-9).',
        '*[!#$%&?@ "]' => 'The password must contain at least one special character(!#$%&?@ ").',
    ];
    public function validate(array $formData, string $field, array $params): bool
    {
        foreach ($this->rules as $rule => $message) {
            if (!preg_match("/.$rule/", $formData[$field]))
                return false;
        }
        return true;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        $messages = '';
        foreach ($this->rules as $rule => $message) {
            if (!preg_match("/.$rule/", $formData[$field]))
                $messages = $message . " " . $messages;
        }
        return $messages;
    }
}
