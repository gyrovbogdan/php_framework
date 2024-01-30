<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use Framework\Exceptions\ValidationException;
use App\Services\{ReceiptService, TransactionService, ValidatorService};

class ReceiptController
{
    private ValidatorService $validator;

    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private ReceiptService $receiptService
    ) {
        $this->validator = new ValidatorService();
    }

    public function uploadView(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction((int) $params['transaction']);
        if (!$transaction) {
            redirectTo("/");
            return;
        }

        echo $this->view->render("receipts/create.php", [
            'id' => $transaction['id']
        ]);
    }

    public function upload(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction((int) $params['transaction']);
        if (!$transaction) {
            redirectTo("/");
            return;
        }

        $this->validator->validateReceipt($_FILES, $errors);

        if ($errors) {
            throw new ValidationException($errors);
        }

        $this->receiptService->upload((int) $params['transaction'], $_FILES['receipt']);

        redirectTo("/");
    }

    public function download(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction((int) $params['transaction']);
        if (!$transaction) {
            redirectTo('/');
            return;
        }

        $receipt = $this->receiptService->getReceipt((int) $params['receipt']);
        if (!$receipt || $receipt['transaction_id'] !== $transaction['id']) {
            redirectTo('/');
            return;
        }

        $this->receiptService->download($receipt);
    }

    public function delete(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction((int) $params['transaction']);
        if (!$transaction) {
            redirectTo('/');
            return;
        }

        $receipt = $this->receiptService->getReceipt((int) $params['receipt']);
        if (!$receipt || $receipt['transaction_id'] !== $transaction['id']) {
            redirectTo('/');
            return;
        }

        $this->receiptService->delete($receipt);

        redirectTo('/');
    }
}
