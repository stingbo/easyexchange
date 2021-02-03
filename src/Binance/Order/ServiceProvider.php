<?php

namespace EasyExchange\Binance\Order;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['order'] = function ($app) {
            return new Client($app);
        };
    }
}
