<?php

namespace Framework\View;

use Exception;
use Framework\View\Engine\Engine;

class Manager
{
    protected array $paths = [];
    protected array $engines = [];

    public function addPath(string $path): static
    {
        array_push($this->paths, $path);
        return $this;
    }

    public function addEngine(string $extension, Engine $engine): static
    {
        $this->engines[$extension] = $engine;
        return $this;
    }

    public function render(string $view, array $data = []): string
    {
        foreach ($this->engines as $extension => $engine) {
            foreach ($this->paths as $path) {
                $file = "{$path}/{$view}.{$extension}";

                if (file_exists($file)) {
                    return $engine->render($file, $data);
                }
            }
        }

        throw new Exception("Could not render '{$view}'");
    }
}
