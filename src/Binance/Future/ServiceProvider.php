<?php

namespace EasyExchange\Binance\Future;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['future'] = function ($app) {
            return new Client($app);
        };
    }
}
