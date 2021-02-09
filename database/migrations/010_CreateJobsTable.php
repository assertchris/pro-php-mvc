<?php

use Framework\Database\Connection\Connection;

class CreateJobsTable
{
    public function migrate(Connection $connection)
    {
        $table = $connection->createTable('jobs');
        $table->id('id');
        $table->text('closure');
        $table->text('params');
        $table->int('attempts')->default(0);
        $table->bool('is_complete')->default(false);
        $table->execute();
    }
}
