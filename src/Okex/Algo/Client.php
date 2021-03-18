<?php

namespace EasyExchange\Okex\Algo;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 策略委托下单.
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
        return $this->httpPostJson('/api/v5/trade/order-algo', $params, [], 'SIGN');
    }

    /**
     * 撤销策略委托订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($params)
    {
        return $this->httpPostJson('/api/v5/trade/cancel-algos', $params, [], 'SIGN');
    }

    /**
     * 获取未完成策略委托单列表.
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
        return $this->httpGet('/api/v5/trade/orders-algo-pending', $params, 'SIGN');
    }
}