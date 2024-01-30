<?php

use Framework\Http;

function dd(mixed $value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function e(mixed $value)
{
    return htmlspecialchars((string) $value);
}

function redirectTo(string $url)
{
    header("Location: {$url}");
    http_response_code(Http::REDIRECT_STATUS_CODE);
}
