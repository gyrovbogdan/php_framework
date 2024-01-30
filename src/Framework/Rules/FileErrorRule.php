<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class FileErrorRule implements RuleInterface
{
    function validate(array $formData, string $field, array $params): bool
    {
        return $formData['error'] === 0;
    }

    function getMessage(array $formData, string $field, array $params): string
    {
        switch ($formData[$field]) {
            case 1:
                return 'File exceeded upload max filesize.';
            case 2:
                return 'File exceeded max file size.';
            case 3:
                return 'File only partially uploaded.';
            case 4:
                return 'No file uploaded.';
            default:
                return 'Unknown file error.';
        }
    }
}
