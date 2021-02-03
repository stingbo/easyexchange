<?php

namespace EasyExchange\Binance\Order;

class Client extends BaseClient
{
    /**
     * place an order.
     */
    public function doOrder($symbol)
    {
        $data = \compact('symbol');

        return $this->httpPost('/api/v3/order', $data);
    }
}
