<?php

namespace EasyExchange\Okex\Basic;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取当前系统时间戳.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function systemTime()
    {
        return $this->httpGet('/api/v5/public/time');
    }

    /**
     * 获取所有可交易产品的信息列表.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exchangeInfo($params)
    {
        return $this->httpGet('/api/v5/public/instruments', $params);
    }

    /**
     * 获取交割和行权记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deliveryExerciseHistory($params)
    {
        return $this->httpGet('/api/v5/public/delivery-exercise-history', $params);
    }

    /**
     * 获取持仓总量.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openInterest($params)
    {
        return $this->httpGet('/api/v5/public/open-interest', $params);
    }

    /**
     * 获取永续合约当前资金费率.
     *
     * @param $instId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fundingRate($instId)
    {
        return $this->httpGet('/api/v5/public/funding-rate', compact('instId'));
    }
}
