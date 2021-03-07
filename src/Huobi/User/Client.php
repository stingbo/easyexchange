<?php

namespace EasyExchange\Huobi\User;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get all Accounts of the Current User.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accounts()
    {
        return $this->httpGet('/v1/account/accounts', [], 'SIGN');
    }

    /**
     * 账户余额.
     *
     * @param $account_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function balance($account_id)
    {
        return $this->httpGet(sprintf('/v1/account/accounts/%s/balance', $account_id), [], 'SIGN');
    }

    /**
     * 按照BTC或法币计价单位，获取指定账户的总资产估值.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function assetValuation($params)
    {
        return $this->httpGet('/v2/account/asset-valuation', $params, 'SIGN');
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
        return $this->httpPost('/v1/account/transfer', $params, 'SIGN');
    }

    /**
     * 账户流水.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function history($params)
    {
        return $this->httpGet('/v1/account/history', $params, 'SIGN');
    }

    /**
     * 财务流水.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ledger($params)
    {
        return $this->httpGet('/v2/account/ledger', $params, 'SIGN');
    }

    /**
     * 币币现货账户与合约账户划转.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function futuresTransfer($params)
    {
        return $this->httpPost('/v1/futures/transfer', $params, 'SIGN');
    }

    /**
     * 点卡余额查询.
     *
     * @param $subUid
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function point($subUid = '')
    {
        $request = [];
        if ($subUid) {
            $request['subUid'] = $subUid;
        }

        return $this->httpGet('/v2/point/account', $request, 'SIGN');
    }

    /**
     * 点卡划转.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pointTransfer($params)
    {
        return $this->httpPost('/v2/point/transfer', $params, 'SIGN');
    }
}
