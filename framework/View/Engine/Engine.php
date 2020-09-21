<?php

namespace Framework\View\Engine;

interface Engine
{
    public function render(string $path, array $data = []): string;
}
