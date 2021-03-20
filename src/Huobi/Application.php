<?php

namespace EasyExchange\Huobi;

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
        Algo\ServiceProvider::class,
        Basic\ServiceProvider::class,
        C2C\ServiceProvider::class,
        Margin\ServiceProvider::class,
        Market\ServiceProvider::class,
        Trade\ServiceProvider::class,
        User\ServiceProvider::class,
        Wallet\ServiceProvider::class,
    ];
}
