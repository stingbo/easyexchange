<?php

namespace EasyExchange\Coinbase\Trade;

use EasyExchange\Coinbase\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Place a New Order.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($params)
    {
        return $this->httpPostJson('/orders', $params, [], 'SIGN');
    }
}
