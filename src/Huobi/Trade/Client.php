<?php

namespace EasyExchange\Huobi\Trade;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    public function order($params)
    {
    }

    public function account()
    {
    }

    /**
     * 查询当前未成交订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openOrders($params)
    {
        return $this->httpGet('/v1/order/openOrders', $params, 'TRADE');
    }
}
