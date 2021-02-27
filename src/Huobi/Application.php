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
        Basic\ServiceProvider::class,
        Spot\ServiceProvider::class,
        Wallet\ServiceProvider::class,
        Market\ServiceProvider::class,
    ];
}
