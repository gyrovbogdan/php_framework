<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\ValidatorService;
use Framework\Exceptions\ValidationException;
use Framework\TemplateEngine;

class TransactionController
{
    private ValidatorService $validator;

    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService
    ) {
        $this->validator = new ValidatorService();
    }

    public function createView()
    {
        echo $this->view->render("transactions/create.php");
    }

    public function create()
    {
        $this->validator->validateTransactions($_POST, $errors);
        if ($errors)
            throw new ValidationException($errors);

        $this->transactionService->create($_POST);

        redirectTo('/');
    }


    public function editView(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction((int) $params['transaction']);
        echo $this->view->render('transactions/edit.php', ['transaction' => $transaction]);
    }

    public function edit(array $params)
    {
        $this->transactionService->edit((int) $params['transaction'], $_POST);
    }

    public function delete(array $params)
    {
        $this->transactionService->delete((int) $params['transaction']);
        redirectTo('/');
    }
}
