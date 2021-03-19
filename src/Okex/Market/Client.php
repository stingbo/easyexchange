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
}
