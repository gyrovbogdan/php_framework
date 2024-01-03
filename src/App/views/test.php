<?php

$functions = [
    function (callable $next) {
        echo "A" . "<br>";
        $next();
    },
    function (callable $next) {
        echo "B" . "<br>";
        $next();
    },
    function (callable $next) {
        echo "C" . "<br>";
        $next();
    }
];

$a = function () {
    echo "D" . "<br>";
};

foreach ($functions as $function) {
    $a = fn () => $function($a);
}

$a();

dd($a);
