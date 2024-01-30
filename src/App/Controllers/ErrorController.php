<?php

namespace App\Controllers;

use App\Services\TransactionService;
use Framework\TemplateEngine;


class ErrorController
{
    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function notFound()
    {
        echo $this->view->render('/notFound.php');
    }
}
