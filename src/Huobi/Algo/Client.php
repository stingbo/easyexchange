<?php

namespace EasyExchange\Huobi\Algo;

use EasyExchange\Huobi\Kernel\BaseClient;

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
        return $this->httpPostJson('/v2/algo-orders', $params, [], 'SIGN');
    }

    /**
     * 策略委托（触发前）撤单.
     *
     * @param $clientOrderIds
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($clientOrderIds)
    {
        return $this->httpPostJson('/v2/algo-orders/cancellation', compact('clientOrderIds'), [], 'SIGN');
    }

    /**
     * 查询未触发OPEN策略委托.
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
        return $this->httpGet('/v2/algo-orders/opening', $params, 'SIGN');
    }

    /**
     * 查询策略委托历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function history($params)
    {
        return $this->httpGet('/v2/algo-orders/history', $params, 'SIGN');
    }

    /**
     * 查询特定策略委托.
     *
     * @param $clientOrderId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function specific($clientOrderId)
    {
        return $this->httpGet('/v2/algo-orders/specific', compact('clientOrderId'), 'SIGN');
    }
}
