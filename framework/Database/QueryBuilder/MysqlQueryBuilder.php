<?php

namespace Framework\Database\QueryBuilder;

use Framework\Database\Connection\MysqlConnection;

class MysqlQueryBuilder extends QueryBuilder
{
    private MysqlConnection $connection;

    public function __construct(MysqlConnection $connection)
    {
        $this->connection = $connection;
    }

    public function connection(): MysqlConnection
    {
        return $this->connection;
    }
}
