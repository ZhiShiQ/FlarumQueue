<?php

namespace ZhiShiQ\Flarum\Queue\Console;

class WorkCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('queue:work')
            ->setDescription('Generate a migration');
    }

    /**
     * {@inheritdoc}
     */
    protected function fire()
    {
        $command = $this->container->make('command.queue.work');
        $command->setLaravel($this->container);
        $command->run($this->input, $this->output);
    }
}
