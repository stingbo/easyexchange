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

    /**
     * 混合保证金借款历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function borrowHistory($params)
    {
        return $this->httpGet('/sapi/v1/futures/loan/borrow/history', $params, 'SIGN');
    }

    /**
     * 混合保证金还款.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repay($params)
    {
        return $this->httpPost('/sapi/v1/futures/loan/repay', $params, 'SIGN');
    }

    /**
     * 混合保证金还款历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repayHistory($params)
    {
        return $this->httpGet('/sapi/v1/futures/loan/repay/history', $params, 'SIGN');
    }

    /**
     * 混合保证金钱包 v1 & v2.
     *
     * @param string $version
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function wallet($version = 'v1', $recvWindow = 60000)
    {
        return $this->httpGet(sprintf('/sapi/%s/futures/loan/wallet', $version), compact('recvWindow'), 'SIGN');
    }

    /**
     * 混合保证金信息 v1 & v2.
     *
     * @param $params
     * @param string $version
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function configs($params, $version = 'v1')
    {
        return $this->httpGet(sprintf('/sapi/%s/futures/loan/configs', $version), $params, 'SIGN');
    }

    /**
     * 计算调整后的混合保证金质押率 v1 & v2.
     *
     * @param $params
     * @param string $version
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function calcAdjustLevel($params, $version = 'v1')
    {
        return $this->httpGet(sprintf('/sapi/%v/futures/loan/calcAdjustLevel', $version), $params, 'SIGN');
    }

    /**
     * 可供调整混合保证金质押率的最大额 v1 & v2.
     *
     * @param $params
     * @param string $version
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function calcMaxAdjustAmount($params, $version = 'v1')
    {
        return $this->httpGet(sprintf('/sapi/%s/futures/loan/calcMaxAdjustAmount', $version), $params, 'SIGN');
    }

    /**
     * 调整混合保证金质押率 v1 & v2.
     *
     * @param $params
     * @param string $version
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function adjustCollateral($params, $version = 'v1')
    {
        return $this->httpPost(sprintf('/sapi/%s/futures/loan/adjustCollateral', $version), $params, 'SIGN');
    }
}
