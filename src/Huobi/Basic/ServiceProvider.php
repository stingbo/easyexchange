<?php

namespace EasyExchange\Huobi\Basic;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['basic'] = function ($app) {
            return new Client($app);
        };
    }
}
