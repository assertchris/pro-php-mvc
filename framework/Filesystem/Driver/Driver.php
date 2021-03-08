<?php

namespace Framework\Filesystem\Driver;

use League\Flysystem\Filesystem;

abstract class Driver
{
    protected Filesystem $filesystem;

    public function __construct(array $config)
    {
        $this->filesystem = $this->connect($config);
    }

    abstract protected function connect(array $config): Filesystem;

    public function list(string $path, bool $recursive = false): iterable
    {
        return $this->filesystem->listContents($path, $recursive);
    }

    public function exists(string $path): bool
    {
        return $this->filesystem->fileExists($path);
    }

    public function get(string $path): string
    {
        return $this->filesystem->read($path);
    }

    public function put(string $path, mixed $value): static
    {
        $this->filesystem->write($path, $value);
        return $this;
    }

    public function delete(string $path): static
    {
        $this->filesystem->delete($path);
        return $this;
    }
}
