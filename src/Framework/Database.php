<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException;

class Database
{
    public PDO $connection;
    public function __construct(
        string $prefix,
        array $config,
        string $username,
        string $password
    ) {

        $dsn = "$prefix:" . http_build_query(
            data: $config,
            arg_separator: ';'
        );

        try {
            $this->connection = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            throw new PDOException("Can't connect to database");
        }
    }

    public function query(string $query, array $params)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    }
}
