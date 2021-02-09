<?php

namespace Framework\Email;

use Closure;
use Framework\Email\Driver\Driver;
use Framework\Email\Exception\DriverException;
use Framework\Support\DriverFactory;

class Factory implements DriverFactory
{
    protected array $drivers;

    public function addDriver(string $alias, Closure $driver): static
    {
        $this->drivers[$alias] = $driver;
        return $this;
    }

    public function connect(array $config): Driver
    {
        if (!isset($config['type'])) {
            throw new DriverException('type is not defined');
        }

        $type = $config['type'];

        if (isset($this->drivers[$type])) {
            return $this->drivers[$type]($config);
        }

        throw new DriverException('unrecognised type');
    }
}