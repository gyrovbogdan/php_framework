<?php

require __DIR__ . "/vendor/autoload.php";

use Dotenv\Dotenv;
use App\Config\Paths;
use Framework\Database;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();


$db = new Database(
    $_ENV['DB_PREFIX'],
    [
        'host' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME']
    ],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
);

$createTables = file_get_contents('./database.sql');

$db->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

$stmt = $db->connection->exec($createTables);
