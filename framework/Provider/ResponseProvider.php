<?php

namespace Framework\Provider;

use Framework\App;
use Framework\Http\Response;

class ResponseProvider
{
    public function bind(App $app)
    {
        $app->bind('response', function($app) {
            return new Response();
        });
    }
}
