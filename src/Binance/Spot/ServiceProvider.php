<?php

namespace EasyExchange\Binance\Spot;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['spot'] = function ($app) {
            return new Client($app);
        };
    }
}
