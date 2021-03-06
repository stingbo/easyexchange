<?php

namespace EasyExchange\Huobi\Market;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 深度信息.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($params)
    {
        return $this->httpGet('/market/depth', $params);
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
    public function trades($symbol)
    {
        return $this->httpGet('/market/trade', compact('symbol'));
    }

    /**
     * 查询历史成交.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function historicalTrades($symbol, int $size = 10)
    {
        return $this->httpGet('/market/history/trade', compact('symbol', 'size'));
    }

    /**
     * 聚合行情（Ticker）.
     * 此接口获取ticker信息同时提供最近24小时的交易聚合信息.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aggTrades($symbol)
    {
        return $this->httpGet('/market/detail/merged', compact('symbol'));
    }

    /**
     * 最近24小时行情数据.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hr24($symbol)
    {
        return $this->httpGet('/market/detail', compact('symbol'));
    }

    /**
     * K 线数据（蜡烛图）.
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
        return $this->httpGet('/market/history/kline', $params);
    }

    /**
     * 所有交易对的最新 Tickers.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tickers()
    {
        return $this->httpGet('/market/tickers', []);
    }

    /**
     * 获取杠杆ETP实时净值.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function etp($symbol)
    {
        return $this->httpGet('/market/etp', compact('symbol'));
    }
}
