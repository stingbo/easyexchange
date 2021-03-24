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

    /**
     * Lend or borrow.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loan($params)
    {
        return $this->httpPostJson('/api/v4/margin/loans', $params, [], 'SIGN');
    }

    /**
     * List all loans.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loanHistory($params)
    {
        return $this->httpGet('/api/v4/margin/loans', $params, 'SIGN');
    }

    /**
     * Merge multiple lending loans.
     *
     * @param $currency
     * @param $ids
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function mergeLoan($currency, $ids)
    {
        return $this->httpPostJson('/api/v4/margin/merged_loans', compact('currency', 'ids'), [], 'SIGN');
    }

    /**
     * Retrieve one single loan detail.
     *
     * @param $loan_id
     * @param $side
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($loan_id, $side)
    {
        return $this->httpGet(sprintf('/api/v4/margin/loans/%s', $loan_id), compact('side'), 'SIGN');
    }

    /**
     * Modify a loan.
     *
     * @param $loan_id
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateLoad($loan_id, $params)
    {
        return $this->httpPatch(sprintf('/api/v4/margin/loans/%s', $loan_id), $params, 'SIGN');
    }

    /**
     * Cancel lending loan.
     *
     * @param $loan_id
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelLoad($loan_id, $currency)
    {
        return $this->httpDelete(sprintf('/api/v4/margin/loans/%s', $loan_id), compact('currency'), 'SIGN');
    }

    /**
     * Repay a loan.
     *
     * @param $loan_id
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repayment($loan_id, $params)
    {
        return $this->httpPostJson(sprintf('/api/v4/margin/loans/%s/repayment', $loan_id), $params, [], 'SIGN');
    }

    /**
     * List loan repayment records.
     *
     * @param $loan_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRepayment($loan_id)
    {
        return $this->httpGet(sprintf('/api/v4/margin/loans/%s/repayment', $loan_id), [], 'SIGN');
    }
}
