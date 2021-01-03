<?php

namespace App\Http\Controllers\Users;

use Framework\Routing\Router;

class LogOutUserController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        unset($_SESSION['user_id']);
        $_SESSION['logged_out'] = true;

        return redirect($this->router->route('show-home-page'));
    }
}
