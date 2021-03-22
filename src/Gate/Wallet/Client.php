<?php

namespace EasyExchange\Gate\Wallet;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Generate currency deposit address.
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
        return $this->httpGet('/api/v4/wallet/deposit_address', compact('currency'), 'SIGN');
    }

    /**
     * Retrieve withdrawal records.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawHistory($params)
    {
        return $this->httpGet('/api/v4/wallet/withdrawals', $params, 'SIGN');
    }

    /**
     * Retrieve deposit records.
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
        return $this->httpGet('/api/v4/wallet/deposits', $params, 'SIGN');
    }

    /**
     * Transfer between trading accounts.
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
        return $this->httpPostJson('/api/v4/wallet/transfers', $params, [], 'SIGN');
    }

    /**
     * Transfer between main and sub accounts.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function subAccountTransfer($params)
    {
        return $this->httpPostJson('/api/v4/wallet/sub_account_transfers', $params, [], 'SIGN');
    }

    /**
     * Transfer records between main and sub accounts.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function subAccountTransferHistory($params)
    {
        return $this->httpGet('/api/v4/wallet/sub_account_transfers', $params, 'SIGN');
    }

    /**
     * Retrieve withdrawal status.
     *
     * @param string $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawStatus($currency = '')
    {
        return $this->httpGet('/api/v4/wallet/withdraw_status', compact('currency'), 'SIGN');
    }

    /**
     * Retrieve sub account balances.
     *
     * @param string $sub_uid
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function subAccountBalance($sub_uid = '')
    {
        return $this->httpGet('/api/v4/wallet/sub_account_balances', compact('sub_uid'), 'SIGN');
    }
}
