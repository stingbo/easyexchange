<?php

namespace EasyExchange\Gate\Market;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['market'] = function ($app) {
            return new Client($app);
        };
    }
}
