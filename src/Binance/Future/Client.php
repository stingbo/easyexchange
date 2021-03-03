<?php

namespace EasyExchange\Binance\Future;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 合约资金划转.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transfer($params)
    {
        return $this->httpPost('/sapi/v1/futures/transfer', $params, 'SIGN');
    }

    /**
     * 获取合约资金划转历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transferHistory($params)
    {
        return $this->httpGet('/sapi/v1/futures/transfer', $params, 'SIGN');
    }

    /**
     * 混合保证金借款.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function borrow($params)
    {
        return $this->httpPost('/sapi/v1/futures/loan/borrow', $params, 'SIGN');
    }
}
