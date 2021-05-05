<?php

namespace EasyExchange\Gate;

use EasyExchange\Kernel\ServiceContainer;

/**
 * Class Application.
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Delivery\ServiceProvider::class,
        Future\ServiceProvider::class,
        Margin\ServiceProvider::class,
        Market\ServiceProvider::class,
        Spot\ServiceProvider::class,
        Wallet\ServiceProvider::class,
        Websocket\ServiceProvider::class,
    ];
}
