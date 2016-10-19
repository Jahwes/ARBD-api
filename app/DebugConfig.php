<?php

namespace CinemaHD;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

use WhoopsSilex\WhoopsServiceProvider;

use Silex\Provider;

use Sorien\Provider\DoctrineProfilerServiceProvider;

class DebugConfig implements ServiceProviderInterface
{
    /**
     * @{inheritDoc}
     */
    public function register(Container $app)
    {
        $app->register(new WhoopsServiceProvider);
        $app->register(new Provider\HttpFragmentServiceProvider());
        $app->register(new Provider\TwigServiceProvider());
        $app->register(
            new Provider\WebProfilerServiceProvider(),
            [
                'profiler.cache_dir'    => __DIR__ . '/../tmp/cache/profiler',
                'profiler.mount_prefix' => '/_profiler',
            ]
        );

        if ($app['application_env'] !== 'testing') {
            $app->register(new DoctrineProfilerServiceProvider());
        }
    }
}
