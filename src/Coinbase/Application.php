<?php

namespace EasyExchange\Coinbase;

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
        Margin\ServiceProvider::class,
        Market\ServiceProvider::class,
        Trade\ServiceProvider::class,
        User\ServiceProvider::class,
        Wallet\ServiceProvider::class,
        Socket\ServiceProvider::class,
    ];
}
