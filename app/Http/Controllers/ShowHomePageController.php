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

        // app('session')->put(
        //     'hits', app('session')->get('hits', 0) + 1
        // );

        if (!app('filesystem')->exists('hits.txt')) {
            app('filesystem')->put('hits.txt', '');
        }

        app('filesystem')->put(
            'hits.txt',
            (int) app('filesystem')->get('hits.txt', 0) + 1,
        );

        return view('home', [
            'products' => $productsWithRoutes,
        ]);
    }
}
