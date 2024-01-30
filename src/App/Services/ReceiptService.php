<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use App\Config\Paths;

class ReceiptService
{
    public function __construct(private Database $database)
    {
    }

    public function upload(int $transaction, array $file)
    {
        $storageFileName = bin2hex(random_bytes(16));
        if (move_uploaded_file($file['tmp_name'], Paths::STORAGE_UPLOAD . '/receipts/' . $storageFileName)) {
            $query = 'INSERT INTO receipts (original_filename, storage_filename, media_type, transaction_id)
                VALUES (:originalFilename, :storageFilename, :mediaType, :transactionId)';

            $params = [
                'originalFilename' => $file['name'],
                'storageFilename' => $storageFileName,
                'mediaType' => $file['type'],
                'transactionId' => $transaction
            ];
            $this->database->query($query, $params);
        }
    }

    public function getReceipt(int $id)
    {
        $query = 'SELECT * FROM receipts WHERE id = :id';

        $params = ['id' => $id];

        return $this->database->query($query, $params)[0];
    }

    public function getReceiptsOfTransaction(int $transactionId)
    {
        $query = 'SELECT * FROM receipts WHERE transaction_id = :transactionId';
        $params = ['transactionId' => $transactionId];

        return $this->database->query($query, $params);
    }

    public function download(array $receipt)
    {
        $filePath = Paths::STORAGE_UPLOAD . '/receipts/' . $receipt['storage_filename'];

        if (!is_file($filePath)) {
            redirectTo('/');
            return;
        }

        header("Content-Disposition: inline; filename={$receipt['original_filename']}");
        header("Content-type: {$receipt['media_type']}");


        readfile($filePath);
    }

    public function delete(array $receipt)
    {
        $query = 'DELETE FROM receipts WHERE id = :id';

        $params = ['id' => $receipt['id']];

        $this->database->query($query, $params);

        $filePath =  Paths::STORAGE_UPLOAD . '/receipts/' . $receipt['storage_filename'];

        unlink($filePath);
    }
}
