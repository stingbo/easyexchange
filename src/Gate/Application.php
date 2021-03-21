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
        Market\ServiceProvider::class,
        Spot\ServiceProvider::class,
        Wallet\ServiceProvider::class,
    ];
}
