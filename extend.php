<?php

use Flarum\Console\Event\Configuring;
use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Redis\RedisManager;
use ZhiShiQ\Flarum\Queue\Listener\Listener;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    function (\Flarum\Foundation\Application $container,\Illuminate\Contracts\Cache\Repository $cache, Dispatcher $events) {
        dd($cache);
        $events->listen(Configuring::class, function (Configuring $configuring) {
            $configuring->addCommand($configuring->app->make(\ZhiShiQ\Flarum\Queue\Console\ListenCommand::class));
            $configuring->addCommand($configuring->app->make(\ZhiShiQ\Flarum\Queue\Console\WorkCommand::class));
        });

        $container->singleton(\Illuminate\Queue\Capsule\Manager::class, function ($container) {
            $queue = new \Illuminate\Queue\Capsule\Manager($container);

            $queue->addConnection([
                'driver' => 'redis',
                'queue' => 'default',
            ]);

            $queue->setAsGlobal();
            return $queue;
        });

        $container['config']['queue'] =
            [
                'default' => 'redis',
                'connections' => [
                    'redis' => [
                        'driver' => 'redis',
                        'connection' => 'default',
                        'queue' => 'default',
                        'retry_after' => 90,
                        'block_for' => null,
                    ]
                ]
            ];
        $container->register(\Illuminate\Queue\QueueServiceProvider::class);


        $container->singleton('command.queue.listen', function ($container) {
            return $container->make(\Illuminate\Queue\Console\ListenCommand::class);
        });
        $container->singleton('command.queue.work', function ($container) {
            return $container->make(\Illuminate\Queue\Console\WorkCommand::class);
        });

        $container->singleton(\Illuminate\Queue\Listener::class, function () {
            return new Listener(__DIR__ . "/../../");
        });

        $container->singleton(\Illuminate\Queue\QueueManager::class, function ($container) {
            return new \Illuminate\Queue\QueueManager($container);
        });
        $container->bind(\Illuminate\Contracts\Debug\ExceptionHandler::class, \ZhiShiQ\Flarum\Queue\ExceptionHandler::class);


        $container['config']['database.redis'] = [
            'client' => 'phpredis',
            'default' => [
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => 0,
            ],
        ];
        $container->register(\Illuminate\Redis\RedisServiceProvider::class);

        $container['config']['cache.stores.redis'] = [
            'driver' => 'redis',
            'connection' => 'default',
        ];
        $container['config']['cache.default'] = 'redis';

        $container->register(\Illuminate\Cache\CacheServiceProvider::class);
    },
];
