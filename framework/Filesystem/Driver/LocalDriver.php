<?php

namespace Framework\Filesystem\Driver;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class LocalDriver extends Driver
{
    protected function connect(array $config): Filesystem
    {
        $adapter = new LocalFilesystemAdapter($config['path']);

        return new Filesystem($adapter);
    }
}
