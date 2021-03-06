<?php

namespace EasyExchange\Huobi\Wallet;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 充币地址查询.
     *
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositAddress($currency)
    {
        return $this->httpGet('/v2/account/deposit/address', compact('currency'), 'SIGN');
    }

    /**
     * 提币额度查询.
     *
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawQuota($currency)
    {
        return $this->httpGet('/v2/account/withdraw/quota', compact('currency'), 'SIGN');
    }

    /**
     * 提币地址查询.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawAddress($params)
    {
        return $this->httpGet('/v2/account/withdraw/address', $params, 'SIGN');
    }

    /**
     * 虚拟币提币.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdraw($params)
    {
        return $this->httpPostJson('/v1/dw/withdraw/api/create', $params, [], 'SIGN');
    }

    /**
     * 取消提币.
     *
     * @param $withdraw_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelWithdraw($withdraw_id)
    {
        return $this->httpPostJson(sprintf('/v1/dw/withdraw-virtual/%s/cancel', $withdraw_id), [], [], 'SIGN');
    }

    /**
     * 充提记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositHistory($params)
    {
        return $this->httpGet('/v1/query/deposit-withdraw', $params, 'SIGN');
    }
}
