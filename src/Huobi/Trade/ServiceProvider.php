<?php

namespace EasyExchange\Huobi\Trade;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['trade'] = function ($app) {
            return new Client($app);
        };
    }
}
