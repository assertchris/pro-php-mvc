<?php

namespace Framework\Email\Driver;

interface Driver
{
    public function to(string $to): static;
    public function subject(string $subject): static;
    public function text(string $text): static;
    public function html(string $html): static;
    public function send(): void;
}
