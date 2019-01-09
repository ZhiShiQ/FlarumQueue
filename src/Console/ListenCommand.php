<?php

namespace ZhiShiQ\Flarum\Queue\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ListenCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('queue:listen')
            ->setDescription('Generate a migration')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the migration.'
            )
            ->addOption(
                'extension',
                null,
                InputOption::VALUE_REQUIRED,
                'The extension to generate the migration for.'
            )
            ->addOption(
                'create',
                null,
                InputOption::VALUE_REQUIRED,
                'The table to be created.'
            )
            ->addOption(
                'table',
                null,
                InputOption::VALUE_REQUIRED,
                'The table to migrate.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function fire()
    {
        $command = $this->container->make('command.queue.listen');
        $command->setLaravel($this->container);
        $command->run(new \Symfony\Component\Console\Input\ArgvInput(),
            new \Symfony\Component\Console\Output\ConsoleOutput());
    }
}
