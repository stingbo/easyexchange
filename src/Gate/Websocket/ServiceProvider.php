<?php

namespace EasyExchange\Gate\Websocket;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['websocket'] = function ($app) {
            return new Client($app);
        };
    }
}
