<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class FileTypeRule implements RuleInterface
{
    function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params))
            throw new InvalidArgumentException('Params are empty');

        $fileType = explode('/', $formData[$field])[1];
        return in_array($fileType, $params);
    }

    function getMessage(array $formData, string $field, array $params): string
    {
        return "Wrong file type.";
    }
}
