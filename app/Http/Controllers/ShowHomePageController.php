<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Framework\Routing\Router;

class ShowHomePageController
{
    public function handle(Router $router)
    {
        $cache = app('cache');
        $products = Product::all();

        $productsWithRoutes = array_map(function ($product) use ($router, $cache) {
            $key = "route-for-product-{$product->id}";

            if (!$cache->has($key)) {
                $cache->put($key, $router->route('view-product', ['product' => $product->id]));
            }

            $product->route = $cache->get($key);

            return $product;
        }, $products);

        // app('queue')->push(
        //     fn($name) => app('logging')->info("Hello {$name}"),
        //     'Chris',
        // );

        // app('logging')->info('Send a task into the background');

        // app('queue')->push(
        //     fn($name) => app('email')
        //         ->to('cgpitt@gmail.com')
        //         ->text("Hello {$name}")
        //         ->send(),
        //     'Chris',
        // );

        return view('home', [
            'products' => $productsWithRoutes,
        ]);
    }
}
