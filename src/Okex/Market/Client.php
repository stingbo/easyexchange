<?php

namespace EasyExchange\Okex\Market;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取所有产品行情信息.
     *
     * @param $instType
     * @param string $uly
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tickers($instType, $uly = '')
    {
        return $this->httpGet('/api/v5/market/tickers', compact('instType', 'uly'));
    }

    /**
     * 获取单个产品行情信息.
     *
     * @param $instId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ticker($instId)
    {
        return $this->httpGet('/api/v5/market/tickers', compact('instId'));
    }

    /**
     * 获取指数行情.
     *
     * @param string $quoteCcy
     * @param string $instId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function indexTickers($quoteCcy = '', $instId = '')
    {
        return $this->httpGet('/api/v5/market/index-tickers', compact('quoteCcy', 'instId'));
    }

    /**
     * 获取产品深度.
     *
     * @param $instId
     * @param int $sz
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($instId, $sz = 1)
    {
        return $this->httpGet('/api/v5/market/books', compact('instId', 'sz'));
    }

    /**
     * 获取所有交易产品K线数据.
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
        return $this->httpGet('/api/v5/market/candles', $params);
    }

    /**
     * 获取交易产品历史K线数据（仅主流币）.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function klineHistory($params)
    {
        return $this->httpGet('/api/v5/market/history-candles', $params);
    }

    /**
     * 获取指数K线数据.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function indexKline($params)
    {
        return $this->httpGet('/api/v5/market/index-candles', $params);
    }

    /**
     * 获取标记价格K线数据.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function markPriceKline($params)
    {
        return $this->httpGet('/api/v5/market/mark-price-candles', $params);
    }

    /**
     * 获取交易产品公共成交数据.
     *
     * @param $instId
     * @param int $limit
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trades($instId, $limit = 100)
    {
        return $this->httpGet('/api/v5/market/trades', compact('instId', 'limit'));
    }
}
