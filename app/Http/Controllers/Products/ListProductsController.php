<?php

namespace App\Http\Controllers\Products;

use Framework\Routing\Router;

class ListProductsController
{
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        $parameters = $this->router->current()->parameters();
        $parameters['page'] ??= 1;

        $next = $this->router->route(
            'product-list', [
                'page' => $parameters['page'] + 1,
            ]
        );

        return view('products/list', [
            'parameters' => $parameters,
            'next' => $next,
        ]);
    }
}
