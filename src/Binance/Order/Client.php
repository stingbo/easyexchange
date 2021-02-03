<?php

namespace EasyExchange\Binance\Order;

use EasyExchange\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * place an order.
     */
    public function doOrder($symbol)
    {
        $data = \compact('symbol');
        print_r($data);
        die;

        return $this->httpPost('/api/v3/order', $data);
    }
}
