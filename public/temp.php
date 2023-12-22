<?php
include __DIR__ . '/../src/App/functions.php';

function normalizePath(string $path): string
{
    $path = trim($path, '/');
    return strlen($path) === 0 ?  '/' : "/$path/";
}


echo normalizePath('/home/dir/') . "<br>";
echo normalizePath('home/dir/') . "<br>";
echo normalizePath('/home/dir') . "<br>";
echo normalizePath('/') . "<br>";
