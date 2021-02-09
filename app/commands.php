<?php

use Framework\Database\Command\MigrateCommand;
use Framework\Support\Command\ServeCommand;
use Framework\Queue\Command\WorkCommand;

return [
    MigrateCommand::class,
    ServeCommand::class,
    WorkCommand::class,
];
