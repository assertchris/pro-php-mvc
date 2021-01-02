<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Profile;
use App\Models\Order;
use Framework\Database\Factory;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Framework\Routing\Router;

class ShowHomePageController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        $factory = new Factory();

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        $factory->addConnector('sqlite', function($config) {
            return new SqliteConnection($config);
        });

        $config = require __DIR__ . '/../../../config/database.php';

        $connection = $factory->connect($config[$config['default']]);
        
        $products = $connection
            ->query()
            ->select()
            ->from('products')
            ->all();

        $productsWithRoutes = array_map(fn($product) => array_merge($product, [
            'route' => $this->router->route('view-product', ['product' => $product['id']]),
        ]), $products);

        $user = new User();
        $user->name = 'Chris';
        $user->email = 'cgpitt@gmail.com';
        $user->password = 'password';
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();

        $order1 = new Order();
        $order1->user_id = $user->id;
        $order1->save();

        $order2 = new Order();
        $order2->user_id = $user->id;
        $order2->save();

        dd($user->profile, $profile->user, $user->orders);

        return view('home', [
            'number' => 42,
            'products' => $productsWithRoutes,
        ]);
    }
}
