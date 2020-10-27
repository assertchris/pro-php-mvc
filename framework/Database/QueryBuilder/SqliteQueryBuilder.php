<?php

namespace Framework\Database\QueryBuilder;

use Framework\Database\Connection\SqliteConnection;

class SqliteQueryBuilder extends QueryBuilder
{
    private SqliteConnection $connection;

    public function __construct(SqliteConnection $connection)
    {
        $this->connection = $connection;
    }

    public function connection(): SqliteConnection
    {
        return $this->connection;
    }
}
