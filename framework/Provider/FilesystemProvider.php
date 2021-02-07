<?php

namespace Framework\Provider;

use Framework\App;
use Framework\Filesystem\Factory;
use Framework\Filesystem\Driver\LocalDriver;

class FilesystemProvider
{
    public function bind(App $app): void
    {
        $app->bind('filesystem', function($app) {
            $factory = new Factory();
            $this->addLocalDriver($factory);

            $config = config('filesystem');

            return $factory->connect($config[$config['default']]);
        });
    }

    private function addLocalDriver($factory): void
    {
        $factory->addDriver('local', function($config) {
            return new LocalDriver($config);
        });
    }
}
