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
}
