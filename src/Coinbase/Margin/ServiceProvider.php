<?php

namespace EasyExchange\Coinbase\Margin;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['margin'] = function ($app) {
            return new Client($app);
        };
    }
}
