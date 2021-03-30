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

    /**
     * Single Deposit Or Single Withdrawal.
     *
     * @param $transfer_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTransfer($transfer_id)
    {
        return $this->httpGet(sprintf('/transfers/%s', $transfer_id), [], 'SIGN');
    }

    /**
     * List Payment Methods.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function paymentMethods()
    {
        return $this->httpGet('/payment-methods', [], 'SIGN');
    }

    /**
     * Payment method - Deposit funds from a payment method.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositPaymentMethod($params)
    {
        return $this->httpPostJson('/deposits/payment-method', $params, [], 'SIGN');
    }

    /**
     * Payment method - Withdraw funds to a payment method.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawalPaymentMethod($params)
    {
        return $this->httpPostJson('/withdrawals/payment-method', $params, [], 'SIGN');
    }

    /**
     * Coinbase - Deposit funds from a coinbase account.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositCoinbaseAccount($params)
    {
        return $this->httpPostJson('/deposits/coinbase-account', $params, [], 'SIGN');
    }

    /**
     * Coinbase - Withdraw funds to a coinbase account.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawalCoinbaseAccount($params)
    {
        return $this->httpPostJson('/withdrawals/coinbase-account', $params, [], 'SIGN');
    }

    /**
     * List Accounts - Get a list of your coinbase accounts.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listAccounts()
    {
        return $this->httpGet('/coinbase-accounts', [], 'SIGN');
    }

    /**
     * Generate a Crypto Deposit Address.
     *
     * @param $account_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateDepositAddress($account_id)
    {
        return $this->httpPostJson(sprintf('/coinbase-accounts/%s/addresses', $account_id), [], [], 'SIGN');
    }

    /**
     * Withdraws funds to a crypto address.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawalCrypto($params)
    {
        return $this->httpPostJson('/withdrawals/crypto', $params, [], 'SIGN');
    }
}
