<?php

namespace App\Controllers;

use Framework\TemplateEngine;

class AboutController
{
    public function __construct(private TemplateEngine $view)
    {
    }

    public function about()
    {
        echo $this->view->render("about.php",  ['title' => 'About']);
    }
}
