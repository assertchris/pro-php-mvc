<?php

namespace Framework\Queue;

use Framework\Database\Model;

class Job extends Model
{
    public function getTable(): string
    {
        return config('queue.database.table');
    }

    public function run(): mixed
    {
        $closure = unserialize($this->closure);
        $params = unserialize($this->params);

        return $closure(...$params);
    }
}
