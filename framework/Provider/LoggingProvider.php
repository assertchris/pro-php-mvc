<?php

namespace Framework\Provider;

use Framework\Logging\Factory;
use Framework\Logging\Driver\StreamDriver;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class LoggingProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'logging';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'stream' => function($config) {
                return new StreamDriver($config);
            },
        ];
    }
}
