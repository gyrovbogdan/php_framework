<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use App\Services\ReceiptService;

class TransactionService
{
    public function __construct(private Database $database, private ReceiptService $receiptService)
    {
    }

    public function create(array $formData)
    {
        $query = "INSERT INTO transactions (description, amount, date, user_id)
            VALUES (:description, :amount, :date, :user_id);";
        $params = [
            'description' => $formData['description'],
            'amount'  => $formData['amount'],
            'date'  => $formData['date'],
            'user_id' => $_SESSION['user']
        ];

        $this->database->query($query, $params);
    }

    public function delete(int $id)
    {
        $query = 'DELETE FROM transactions
            WHERE id = :id
            AND user_id = :user_id';

        $params = [
            'id' => $id,
            'user_id' => $_SESSION['user']
        ];

        $this->database->query($query, $params);
    }


    public function getUserTransaction(int $id)
    {
        $query = "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as date FROM transactions 
            WHERE id = :id
            AND user_id = :user";

        $params = [
            'id' => $id,
            'user' => $_SESSION['user']
        ];

        $result = $this->database->query($query, $params);

        return $result[0] ?? [];
    }

    public function getUserTransactions(int $limit = 5)
    {
        $searchTerm = addcslashes($_GET['s'] ?? '', '%_');

        $page = $_GET['p'] ?? 0;
        $offset = $page * $limit;

        $query = "SELECT *, DATE_FORMAT(date, '%m/%d/%Y') as date 
            FROM transactions 
            WHERE user_id = :user
            AND description LIKE :description
            ORDER BY id DESC
            LIMIT {$limit} OFFSET {$offset}";

        $params = [
            'user' => $_SESSION['user'],
            'description' => "%$searchTerm%",
        ];

        $transactions = $this->database->query($query, $params);
        $transactions = array_map(
            function ($transaction) {
                $transaction['receipts'] = $this->receiptService->getReceiptsOfTransaction($transaction['id']);
                return $transaction;
            },
            $transactions
        );

        $query = "SELECT COUNT(*) FROM transactions 
            WHERE user_id = :user
            AND description LIKE :description";

        $params = [
            'user' => $_SESSION['user'],
            'description' => "%$searchTerm%",
        ];

        $count = $this->database->query($query, $params)[0]["COUNT(*)"];

        $pages = ceil($count / $limit);

        return [$transactions, $pages];
    }

    public function edit(int $id, array $formData)
    {
        $query = 'UPDATE transactions
            SET description = :description,
                amount = :amount,
                date = :date
            WHERE user_id = :user_id
            AND id = :id';

        $params = [
            'description' => $formData['description'],
            'amount' => $formData['amount'],
            'date' => $formData['date'],
            'user_id' => $_SESSION['user'],
            'id' => $id
        ];

        $this->database->query($query, $params);

        redirectTo("/");
    }
}
