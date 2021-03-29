<?php

namespace EasyExchange\Coinbase\Wallet;

use EasyExchange\Coinbase\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get Current Exchange Limits.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exchangeLimits()
    {
        return $this->httpGet('/users/self/exchange-limits', [], 'SIGN');
    }

    /**
     * List Deposits Or List Withdrawals.
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
        return $this->httpGet('/transfers', $params, 'SIGN');
    }
}
