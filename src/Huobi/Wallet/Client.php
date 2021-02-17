<?php

namespace EasyExchange\Huobi\Wallet;

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
        return $this->httpGet('/v1/account/accounts', [], 'TRADE');
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
    public function account($account_id)
    {
        return $this->httpGet(sprintf('/v1/account/accounts/%s/balance', $account_id), [], 'TRADE');
    }

    /**
     * 按照BTC或法币计价单位，获取指定账户的总资产估值.
     *
     * @param string $accountType
     * @param string $valuationCurrency
     * @param string $subUid
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function assetValuation($accountType = 'spot', $valuationCurrency = 'BTC', $subUid = '')
    {
        return $this->httpGet('/v2/account/asset-valuation', compact('accountType', 'valuationCurrency', 'subUid'), 'TRADE');
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
        return $this->httpPost('/v1/account/transfer', $params, 'TRADE');
    }
}
