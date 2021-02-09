<?php

namespace Framework\Provider;

use Framework\Email\Factory;
use Framework\Email\Driver\PostmarkDriver;
use Framework\Support\DriverProvider;
use Framework\Support\DriverFactory;

class EmailProvider extends DriverProvider
{
    protected function name(): string
    {
        return 'email';
    }

    protected function factory(): DriverFactory
    {
        return new Factory();
    }

    protected function drivers(): array
    {
        return [
            'postmark' => function($config) {
                return new PostmarkDriver($config);
            },
        ];
    }
}
