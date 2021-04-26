<?php

namespace EasyExchange\Okex\Websocket;

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
            return new WebsocketClient($app);
        };

        $app['websocket_server'] = function ($app) {
            return new WebsocketServer($app);
        };
    }
}
