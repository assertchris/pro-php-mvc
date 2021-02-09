<?php

namespace Framework\Queue\Driver;

use Closure;
use Framework\Queue\Job;

interface Driver
{
    public function push(Closure $closure, ...$params): int;
    public function shift(): ?Job;
}
