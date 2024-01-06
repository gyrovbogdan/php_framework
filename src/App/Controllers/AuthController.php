<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;

class AuthController
{
    private ValidatorService $validator;
    public function __construct(private TemplateEngine $view)
    {
        $this->validator = new ValidatorService;
    }

    public function registerView()
    {
        echo $this->view->render("register.php");
    }

    public function register()
    {
        $this->validator->validateRegister($_POST);
    }
}
