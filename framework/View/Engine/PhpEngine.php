<?php

namespace Framework\View\Engine;

use function view;

class PhpEngine implements Engine
{
    protected string $path;
    protected ?string $layout;
    protected string $contents;

    public function render(string $path, array $data = []): string
    {
        $this->path = $path;

        extract($data);

        ob_start();
        include($this->path);
        $contents = ob_get_contents();
        ob_end_clean();

        if ($this->layout) {
            $__layout = $this->layout;

            $this->layout = null;
            $this->contents = $contents;

            $contentsWithLayout = view($__layout, $data);

            return $contentsWithLayout;
        }

        return $contents;
    }

    protected function escape(string $content): string
    {
        return htmlspecialchars($content);
    }

    protected function extends(string $template): static
    {
        $this->layout = $template;
        return $this;
    }
}
