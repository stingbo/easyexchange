<?php

namespace EasyExchange\Gate\Wallet;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['wallet'] = function ($app) {
            return new Client($app);
        };
    }
}
