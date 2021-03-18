<?php

namespace EasyExchange\Okex\Trade;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 下单.
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
        return $this->httpPostJson('/api/v5/trade/order', $params, [], 'SIGN');
    }

    /**
     * 批量下单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchOrders($params)
    {
        return $this->httpPostJson('/api/v5/trade/batch-orders', $params, [], 'SIGN');
    }

    /**
     * 撤销之前下的未完成订单.
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
        return $this->httpPostJson('/api/v5/trade/cancel-order', $params, [], 'SIGN');
    }

    /**
     * 获取订单信息.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($params)
    {
        return $this->httpGet('/api/v5/trade/order', $params, 'SIGN');
    }
}
