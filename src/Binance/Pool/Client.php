<?php

namespace EasyExchange\Binance\Pool;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取算法.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function algoList($recvWindow = 60000)
    {
        return $this->httpGet('/sapi/v1/mining/pub/algoList', compact('recvWindow'), 'SIGN');
    }

    /**
     * 获取币种.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function coinList($recvWindow = 60000)
    {
        return $this->httpGet('/sapi/v1/mining/pub/coinList', compact('recvWindow'), 'SIGN');
    }

    /**
     * 请求矿工列表明细.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function workerDetail($params)
    {
        return $this->httpGet('/sapi/v1/mining/worker/detail', $params, 'SIGN');
    }

    /**
     * 请求矿工列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function workerList($params)
    {
        return $this->httpGet('/sapi/v1/mining/worker/list', $params, 'SIGN');
    }

    /**
     * 收益列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function paymentList($params)
    {
        return $this->httpGet('/sapi/v1/mining/payment/list', $params, 'SIGN');
    }

    /**
     * 其他收益列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function paymentOther($params)
    {
        return $this->httpGet('/sapi/v1/mining/payment/other', $params, 'SIGN');
    }

    /**
     * 算力转让详情列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hashTransferConfigDetails($params)
    {
        return $this->httpGet('/sapi/v1/mining/hash-transfer/config/details', $params, 'SIGN');
    }

    /**
     * 算力转让列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hashTransferConfigDetailsList($params)
    {
        return $this->httpGet('/sapi/v1/mining/hash-transfer/config/details/list', $params, 'SIGN');
    }

    /**
     * 算力转让详情.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hashTransferProfitDetails($params)
    {
        return $this->httpGet('/sapi/v1/mining/hash-transfer/profit/details', $params, 'SIGN');
    }

    /**
     * 算力转让请求.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hashTransferConfig($params)
    {
        return $this->httpPost('/sapi/v1/mining/hash-transfer/config', $params, 'SIGN');
    }

    /**
     * 取消算力转让设置.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hashTransferConfigCancel($params)
    {
        return $this->httpPost('/sapi/v1/mining/hash-transfer/config/cancel', $params, 'SIGN');
    }

    /**
     * 统计列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userStatus($params)
    {
        return $this->httpGet('/sapi/v1/mining/statistics/user/status', $params, 'SIGN');
    }

    /**
     * 账号列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userList($params)
    {
        return $this->httpGet('/sapi/v1/mining/statistics/user/list', $params, 'SIGN');
    }
}
