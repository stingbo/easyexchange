<?php

namespace EasyExchange\Huobi\Algo;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['algo'] = function ($app) {
            return new Client($app);
        };
    }
}
