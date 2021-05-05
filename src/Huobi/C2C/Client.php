<?php

namespace EasyExchange\Huobi\C2C;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 借入借出下单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($params)
    {
        return $this->httpPostJson('/v2/c2c/offer', $params, [], 'SIGN');
    }

    /**
     * 借入借出撤单.
     *
     * @param $offerId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($offerId)
    {
        return $this->httpPostJson('/v2/c2c/cancellation', compact('offerId'), [], 'SIGN');
    }

    /**
     * 撤销所有借入借出订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelAll($params)
    {
        return $this->httpPostJson('/v2/c2c/cancel-all', $params, [], 'SIGN');
    }

    /**
     * 查询借入借出订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrders($params)
    {
        return $this->httpGet('/v2/c2c/offers', $params, 'SIGN');
    }

    /**
     * 查询特定借入借出订单及其交易记录.
     *
     * @param string $offerId 订单ID
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($offerId)
    {
        return $this->httpGet('/v2/c2c/offer', compact('offerId'), 'SIGN');
    }

    /**
     * 查询借入借出交易记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transactions($params)
    {
        return $this->httpGet('/v2/c2c/transactions', $params, 'SIGN');
    }

    /**
     * 还币.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repayment($params)
    {
        return $this->httpPostJson('/v2/c2c/repayment', $params, [], 'SIGN');
    }

    /**
     * 查询还币交易记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRepayment($params)
    {
        return $this->httpGet('/v2/c2c/repayment', $params, 'SIGN');
    }

    /**
     * 资产划转.
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
        return $this->httpPostJson('/v2/c2c/transfer', $params, [], 'SIGN');
    }

    /**
     * Query C2C account balance.
     *
     * @param $accountId
     * @param string $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function balance($accountId, $currency = '')
    {
        return $this->httpGet('/v2/c2c/account', compact('accountId', 'currency'), 'SIGN');
    }
}
