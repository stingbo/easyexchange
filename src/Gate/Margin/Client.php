<?php

namespace EasyExchange\Gate\Margin;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * List all supported currency pairs supported in margin trading.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currencyPairs()
    {
        return $this->httpGet('/api/v4/margin/currency_pairs');
    }

    /**
     * Query one single margin currency pair.
     *
     * @param $currency_pair
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currencyPair($currency_pair)
    {
        return $this->httpGet(sprintf('/api/v4/margin/currency_pairs/%s', $currency_pair));
    }

    /**
     * Order book of lending loans.
     *
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($currency)
    {
        return $this->httpGet('/api/v4/margin/funding_book', compact('currency'));
    }

    /**
     * Margin account list.
     *
     * @param string $currency_pair
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accounts($currency_pair = '')
    {
        return $this->httpGet('/api/v4/margin/accounts', compact('currency_pair'), 'SIGN');
    }

    /**
     * List margin account balance change history.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accountHistory($params)
    {
        return $this->httpGet('/api/v4/margin/account_book', $params, 'SIGN');
    }

    /**
     * Funding account list.
     *
     * @param string $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fundingAccounts($currency = '')
    {
        return $this->httpGet('/api/v4/margin/funding_accounts', compact('currency'), 'SIGN');
    }
}
