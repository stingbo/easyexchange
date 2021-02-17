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
        Trade\ServiceProvider::class,
        Wallet\ServiceProvider::class,
        Market\ServiceProvider::class,
        User\ServiceProvider::class,
    ];
}
