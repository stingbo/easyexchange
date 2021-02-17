<?php

namespace EasyExchange\Binance\Market;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 深度信息.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($symbol, int $limit = 100)
    {
        return $this->httpGet('/api/v3/depth', compact('symbol', 'limit'));
    }

    /**
     * 近期成交列表.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trades($symbol, int $limit = 500)
    {
        return $this->httpGet('/api/v3/trades', compact('symbol', 'limit'));
    }

    /**
     * 查询历史成交.
     *
     * @param $symbol
     * @param string $fromId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function historicalTrades($symbol, $fromId = '', int $limit = 500)
    {
        return $this->httpGet('/api/v3/historicalTrades', compact('symbol', 'fromId', 'limit'));
    }

    /**
     * 近期成交(归集).
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aggTrades($params)
    {
        return $this->httpGet('/api/v3/aggTrades', $params);
    }

    /**
     * 24hr 价格变动情况.
     *
     * @param string $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hr24($symbol = '')
    {
        return $this->httpGet('/api/v3/ticker/24hr', $symbol ? compact('symbol') : []);
    }

    /**
     * K线数据.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kline($params)
    {
        return $this->httpGet('/api/v3/klines', $params);
    }

    /**
     * 当前平均价格.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function avgPrice($symbol)
    {
        return $this->httpGet('/api/v3/avgPrice', compact('symbol'));
    }

    /**
     * 获取交易对最新价格.
     *
     * @param string $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function price($symbol = '')
    {
        return $this->httpGet('/api/v3/ticker/price', $symbol ? compact('symbol') : []);
    }
}
