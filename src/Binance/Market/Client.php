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
}
