<?php

namespace EasyExchange\Binance;

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
        Basic\ServiceProvider::class,
        Future\ServiceProvider::class,
        Margin\ServiceProvider::class,
        Market\ServiceProvider::class,
        Pool\ServiceProvider::class,
        Spot\ServiceProvider::class,
        User\ServiceProvider::class,
        Wallet\ServiceProvider::class,
        Websocket\ServiceProvider::class,
    ];
}
