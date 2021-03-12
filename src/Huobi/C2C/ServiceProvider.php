<?php

namespace EasyExchange\Huobi\C2C;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['c2c'] = function ($app) {
            return new Client($app);
        };
    }
}
