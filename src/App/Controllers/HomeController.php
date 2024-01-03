<?php

namespace App\Controllers;

use Framework\TemplateEngine;

class HomeController
{
    public function __construct(private TemplateEngine $view)
    {
    }

    public function home()
    {
        echo $this->view->render("index.php");
    }

    public function test()
    {
        echo $this->view->render("test.php", ['title' => 'Home']);
    }
}
