<?php

namespace EasyExchange\Huobi\Margin;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 归还借币（全仓逐仓通用）.
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
        return $this->httpPostJson('/v2/account/repayment', $params, [], 'SIGN');
    }

    /**
     * 资产划转（逐仓）-从现货账户划转至逐仓杠杆账户.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transferIn($params)
    {
        return $this->httpPostJson('/v1/dw/transfer-in/margin', $params, [], 'SIGN');
    }

    /**
     * 资产划转（逐仓）-从逐仓杠杆账户划转至现货账户.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transferOut($params)
    {
        return $this->httpPostJson('/v1/dw/transfer-out/margin', $params, [], 'SIGN');
    }

    /**
     * 查询借币币息率及额度（逐仓）.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loanInfo($params)
    {
        return $this->httpGet('/v1/margin/loan-info', $params, 'SIGN');
    }

    /**
     * 申请借币（逐仓）.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orders($params)
    {
        return $this->httpPostJson('/v1/margin/orders', $params, [], 'SIGN');
    }
}
