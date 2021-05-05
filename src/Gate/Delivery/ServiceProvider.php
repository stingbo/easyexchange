<?php

namespace EasyExchange\Gate\Delivery;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['delivery'] = function ($app) {
            return new Client($app);
        };
    }
}
