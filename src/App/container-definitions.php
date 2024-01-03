<?php

use Framework\TemplateEngine;
use App\Config\Paths;

return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEWS)
];
