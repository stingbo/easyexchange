<?php

namespace EasyExchange\Huobi\Spot;

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
        return $this->httpPostJson('/v1/order/orders/place', $params, [], 'SIGN');
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
        return $this->httpPost(sprintf('/v1/order/orders/%s/submitcancel', $order_id), [], 'SIGN');
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
        return $this->httpPostJson('/v1/order/batch-orders', $params, [], 'SIGN');
    }

    /**
     * 撤销订单（基于client order ID）.
     *
     * @param $client_order_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelClientOrder($client_order_id)
    {
        return $this->httpPostJson('/v1/order/orders/submitCancelClientOrder', compact('client_order_id'), [], 'SIGN');
    }

    /**
     * 自动撤销订单.
     *
     * @param $timeout
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelAllAfter($timeout)
    {
        return $this->httpPostJson('/v2/algo-orders/cancel-all-after', compact('timeout'), [], 'SIGN');
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
        return $this->httpGet('/v1/order/openOrders', $params, 'SIGN');
    }

    /**
     * 批量撤销所有订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchCancelOpenOrders($params)
    {
        return $this->httpPostJson('/v1/order/orders/batchCancelOpenOrders', $params, [], 'SIGN');
    }

    /**
     * 批量撤销指定订单.
     *
     * @param array $order_ids
     * @param array $client_order_ids
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchCancel($order_ids = [], $client_order_ids = [])
    {
        return $this->httpPostJson('/v1/order/orders/batchcancel', compact('order_ids', 'client_order_ids'), [], 'SIGN');
    }
}
