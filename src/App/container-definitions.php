<?php

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{ReceiptService, TransactionService, UserService, ValidatorService};
use Framework\{Container, Database};

return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEWS),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn () => new Database(
        $_ENV['DB_PREFIX'],
        [
            'host' => $_ENV['DB_HOST'],
            'dbname' => $_ENV['DB_NAME']
        ],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    ),
    UserService::class => function (Container $container) {
        $database = $container->get(Database::class);
        return new UserService($database);
    },
    ReceiptService::class => function (Container $container) {
        $database = $container->get(Database::class);
        return new ReceiptService($database);
    },
    TransactionService::class => function (Container $container) {
        $database = $container->get(Database::class);
        $receiptService = $container->get(ReceiptService::class);
        return new TransactionService($database, $receiptService);
    },
];
