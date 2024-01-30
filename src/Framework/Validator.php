<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;

class Validator
{
    private array $rules = [];

    public function validate(array $data, array $fields, &$errors): bool
    {
        $isValid = true;
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
                $isValid = false;
                $errors[$fieldName][] = $ruleValidator->getMessage($data, $fieldName, $ruleParams);
            }
        }
        return $isValid;
    }

    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }
}
