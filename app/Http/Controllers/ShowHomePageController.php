<?php

namespace App\Http\Controllers;

use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;

class ShowHomePageController
{
    public function handle()
    {
        $factory = new Factory();

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        // $factory->addConnector('sqlite', function($config) {
        //     return new SqliteConnection($config);
        // });

        $connection = $factory->connect([
            'type' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'pro-php-mvc',
            'username' => 'root',
            'password' => '',
        ]);

        // $connection = $factory->connect([
        //     'type' => 'sqlite',
        //     'path' => __DIR__ . '/../../../database/database.sqlite',
        // ]);
        
        $product = $connection
            ->query()
            ->select()
            ->from('products')
            ->first();

        $table = 'test_' . time();

        $createMigration = $connection->createTable($table);
        $createMigration->id('id');
        $createMigration->int('quantity')->default(1);
        $createMigration->float('price')->nullable();
        $createMigration->bool('is_confirmed')->default(false);
        $createMigration->dateTime('ordered_at')->default('CURRENT_TIMESTAMP');
        $createMigration->text('notes');
        $createMigration->execute();

        return view('home', [
            'number' => 42,
            'featured' => $product,
        ]);
    }
}
