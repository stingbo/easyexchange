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
        Market\ServiceProvider::class,
        Spot\ServiceProvider::class,
        User\ServiceProvider::class,
        Wallet\ServiceProvider::class,
    ];
}
