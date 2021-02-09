<?php

namespace Framework\Queue\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;

class WorkCommand extends Command
{
    protected static $defaultName = 'queue:work';

    protected function configure()
    {
        $this
            ->setDescription('Runs tasks that have been queued')
            ->setHelp('This command waits for and runs queued jobs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Waiting for jobs.</info>');

        while(true) {
            if ($job = app('queue')->shift()) {
                try {
                    $job->run();

                    $output->writeln("<info>Completed {$job->id}</info>");

                    $job->is_complete = true;
                    $job->save();

                    sleep(1);
                }
                catch (Exception $e) {
                    $message = $e->getMessage();
                    $output->writeln("<error>{$message}</error>");

                    $job->attempts = $job->attempts + 1;
                    $job->save();
                }
            }
        }
    }
}
