<?php

namespace EasyExchange\Coinbase\User;

use EasyExchange\Coinbase\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * List Accounts - Get a list of trading accounts from the profile of the API key.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accounts()
    {
        return $this->httpGet('/accounts', [], 'SIGN');
    }

    /**
     * Get an Account - Information for a single account.
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
        return $this->httpGet(sprintf('/accounts/%s', $account_id), [], 'SIGN');
    }

    /**
     * Get Account History - List account activity of the API key's profile.
     *
     * @param $account_id
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function history($account_id, $params = [])
    {
        return $this->httpGet(sprintf('/accounts/%s/ledger', $account_id), $params, 'SIGN');
    }

    /**
     * Get Holds - List holds of an account that belong to the same profile as the API key.
     *
     * @param $account_id
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function holds($account_id, $params = [])
    {
        return $this->httpGet(sprintf('/accounts/%s/holds', $account_id), $params, 'SIGN');
    }

    /**
     * List Accounts - Get a list of your coinbase accounts.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function coinbaseAccounts()
    {
        return $this->httpGet('/coinbase-accounts', [], 'SIGN');
    }
}
