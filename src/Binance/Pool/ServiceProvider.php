<?php

namespace EasyExchange\Binance\Pool;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['pool'] = function ($app) {
            return new Client($app);
        };
    }
}
