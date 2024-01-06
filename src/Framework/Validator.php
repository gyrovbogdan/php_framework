<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];

    public function validate(array $data, array $fields)
    {
        $errors = [];
        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];

                if (str_contains($rule, ":")) {
                    [$rule, $ruleParams] = explode(":", $rule);
                    $ruleParams = explode(',', $ruleParams);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($data, $fieldName, $ruleParams))
                    continue;
                $errors[$fieldName][] = $ruleValidator->getMessage($data, $fieldName, $ruleParams);
            }
        }
        if ($errors)
            throw new ValidationException($errors);
    }

    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }
}
