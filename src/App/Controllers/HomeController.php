<?php

namespace App\Controllers;

use App\Services\TransactionService;
use Framework\TemplateEngine;

class HomeController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService
    ) {
    }

    public function home()
    {
        [$transactions, $pages] = $this->transactionService->getUserTransactions();

        $this->view->addGlobal('transactions', $transactions);
        $this->view->addGlobal('pages', $pages);

        if (!isset($_GET['p']) || $_GET['p'] > $pages || $_GET['p'] < 0) {
            $_GET['p'] = 0;
        }

        $this->view->addGlobal('currentPage', $_GET['p']);
        $this->view->addGlobal('searchTerm', $_GET['s'] ?? '');

        echo $this->view->render("index.php");
    }
}
