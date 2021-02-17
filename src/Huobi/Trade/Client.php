<?php

namespace EasyExchange\Huobi\Trade;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * new order.
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
        return $this->httpPostJson('/v1/order/orders/place', $params, [], 'TRADE');
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

    /**
     * 撤销订单.
     *
     * @param $order_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($order_id)
    {
        return $this->httpPost(sprintf('/v1/order/orders/%s/submitcancel', $order_id), [], 'TRADE');
    }
}
