<?php
/**
 * Created by IntelliJ IDEA.
 * User: bill
 * Date: 2019-01-04
 * Time: 17:08
 */

namespace ZhiShiQ\Flarum\Queue\Console;

use Illuminate\Queue\Capsule\Manager as Queue;

abstract class AbstractCommand extends \Flarum\Console\AbstractCommand
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;
    /**
     * @var Queue
     */
    protected $queue;

    public function __construct(\Illuminate\Queue\Capsule\Manager $queue, \Illuminate\Contracts\Container\Container $container, ?string $name = null)
    {
        parent::__construct($name);
        $this->container = $container;
        $this->queue = $queue;
    }
}
