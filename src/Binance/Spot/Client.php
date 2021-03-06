<?php

namespace EasyExchange\Binance\Spot;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 测试下单.
     *
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderTest($params)
    {
        return $this->httpPost('/api/v3/order/test', $params);
    }

    /**
     * 下单.
     *
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($params)
    {
        return $this->httpPost('/api/v3/order', $params, 'SIGN');
    }

    /**
     * 获取交易对的所有当前挂单.
     *
     * @param string $symbol
     * @param int    $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openOrders($symbol = '', $recvWindow = 60000)
    {
        $request = [];
        if ($symbol) {
            $request['symbol'] = $symbol;
        }
        if ($recvWindow) {
            $request['recvWindow'] = $recvWindow;
        }

        return $this->httpGet('/api/v3/openOrders', $request, 'SIGN');
    }

    /**
     * 撤销订单.
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
        return $this->httpDelete('/api/v3/order', $params, 'SIGN');
    }

    /**
     * 撤销单一交易对的所有挂单.
     *
     * @param $symbol
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrders($symbol, $recvWindow = 60000)
    {
        return $this->httpDelete('api/v3/openOrders', compact('symbol', 'recvWindow'), 'SIGN');
    }

    /**
     * 查询订单.
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
        return $this->httpGet('/api/v3/order', $params, 'SIGN');
    }

    /**
     * 获取所有帐户订单； 有效，已取消或已完成.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function allOrders($params)
    {
        return $this->httpGet('/api/v3/allOrders', $params, 'SIGN');
    }

    /**
     * 获取账户指定交易对的成交历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function myTrades($params)
    {
        return $this->httpGet('/api/v3/myTrades', $params, 'SIGN');
    }

    /**
     * OCO下单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function oco($params)
    {
        return $this->httpPost('/api/v3/order/oco', $params, 'SIGN');
    }

    /**
     * 取消 OCO 订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOcoOrder($params)
    {
        return $this->httpDelete('/api/v3/orderList', $params, 'SIGN');
    }

    /**
     * 查询 OCO.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOcoOrder($params)
    {
        return $this->httpGet('/api/v3/orderList', $params, 'SIGN');
    }

    /**
     * 查询所有 OCO.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function allOrderList($params)
    {
        return $this->httpGet('/api/v3/allOrderList', $params, 'SIGN');
    }

    /**
     * 查询 OCO 挂单.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openOrderList($recvWindow = 10000)
    {
        return $this->httpGet('/api/v3/openOrderList', compact('recvWindow'), 'SIGN');
    }
}
