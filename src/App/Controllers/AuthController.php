<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;
use Framework\TemplateEngine;
use App\Services\ValidatorService;
use Framework\Exceptions\ValidationException;
use App\Exceptions\AuthenticationException;

class AuthController
{
    private ValidatorService $validator;
    public function __construct(private TemplateEngine $view, private UserService $userService)
    {
        $this->validator = new ValidatorService;
    }

    public function registerView()
    {
        echo $this->view->render("users/register.php");
    }

    public function register()
    {
        $errors = [];
        $this->validator->validateRegister($_POST, $errors);
        $this->userService->isEmailTaken($_POST['email'], $errors);

        if ($errors)
            throw new ValidationException($errors);

        $this->userService->create($_POST);

        $_SESSION['user'] = $this->userService->id();
        unset($_SESSION['errors']);

        redirectTo('/');
    }

    public function loginView()
    {
        echo $this->view->render('users/login.php');
    }

    public function login()
    {
        $errors = [];
        $this->validator->validateLogin($_POST, $errors);

        if ($errors)
            throw new ValidationException($errors);

        if ($this->userService->checkPassword($_POST, $id)) {
            unset($_SESSION['email']);
            $_SESSION['user'] = $id;
            redirectTo('/');
        } else
            throw new AuthenticationException("Email or password is incorrect.");
    }

    public function logout()
    {
        session_destroy();

        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );

        redirectTo('/login');
    }
}
