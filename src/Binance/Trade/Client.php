<?php

namespace EasyExchange\Binance\Trade;

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
        return $this->httpPost('/api/v3/order', $params, 'TRADE');
    }

    /**
     * 账户信息.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function account($recvWindow = 60000)
    {
        return $this->httpGet('/api/v3/account', compact('recvWindow'), 'TRADE');
    }

    /**
     * 当前挂单.
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

        return $this->httpGet('/api/v3/openOrders', $request, 'TRADE');
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
        return $this->httpDelete('/api/v3/order', $params, 'TRADE');
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
        return $this->httpDelete('api/v3/openOrders', compact('symbol', 'recvWindow'), 'TRADE');
    }
}
