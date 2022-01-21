<?php

namespace EasyExchange\Okex\Trading;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['trading'] = function ($app) {
            return new Client($app);
        };
    }
}
