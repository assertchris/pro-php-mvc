<?php

use App\Http\Controllers\ShowHomePageController;
use App\Http\Controllers\Products\ListProductsController;
use App\Http\Controllers\Products\ShowProductController;
use App\Http\Controllers\Services\ShowServiceController;
use Framework\Routing\Router;

return function(Router $router) {
    $router->add(
        'GET', '/',
        [ShowHomePageController::class, 'handle'],
    );

    $router->errorHandler(
        404, fn() => 'whoops!'
    );

    $showProductController = new ShowProductController($router);

    $router->add(
        'GET', '/products/view/{product}',
        [$showProductController, 'handle'],
    );

    $listProductsController = new ListProductsController($router);

    $router->add(
        'GET', '/products/{page?}',
        [$listProductsController, 'handle'],
    )->name('product-list');

    $showServiceController = new ShowServiceController($router);

    $router->add(
        'GET', '/services/view/{service?}',
        [$showServiceController, 'handle'],
    );
};
