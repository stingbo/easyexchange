<?php

namespace EasyExchange\Gate\Spot;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * List all currencies' detail.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currencies()
    {
        return $this->httpGet('/api/v4/spot/currencies');
    }

    /**
     * Get detail of one particular currency.
     *
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currency($currency)
    {
        return $this->httpGet(sprintf('/api/v4/spot/currencies/%s', $currency));
    }

    /**
     * List all currency pairs supported.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currencyPairs()
    {
        return $this->httpGet('/api/v4/spot/currency_pairs');
    }

    /**
     * Get detail of one single order.
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
        return $this->httpGet(sprintf('/api/v4/spot/currency_pairs/%s', $currency_pair));
    }

    /**
     * Retrieve ticker information.
     *
     * @param string $currency_pair
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tickers($currency_pair = '')
    {
        return $this->httpGet('/api/v4/spot/tickers', compact('currency_pair'));
    }

    /**
     * Retrieve order book.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($params)
    {
        return $this->httpGet('/api/v4/spot/order_book', $params);
    }

    /**
     * Retrieve market trades.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trades($params)
    {
        return $this->httpGet('/api/v4/spot/trades', $params);
    }

    /**
     * Market candlesticks.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kline($params)
    {
        return $this->httpGet('/api/v4/spot/candlesticks', $params);
    }

    /**
     * List spot accounts.
     *
     * @param string $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accounts($currency = '')
    {
        return $this->httpGet('/api/v4/spot/accounts', compact('currency'), 'SIGN');
    }

    /**
     * Create an order.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($params)
    {
        return $this->httpPostJson('/api/v4/spot/orders', $params, [], 'SIGN');
    }

    /**
     * Create a batch of orders.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchOrders($params)
    {
        return $this->httpPostJson('/api/v4/spot/batch_orders', $params, [], 'SIGN');
    }

    /**
     * List all open orders.
     *
     * @param string $page
     * @param string $limit
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openOrders($page = '', $limit = '')
    {
        return $this->httpGet('/api/v4/spot/open_orders', compact('page', 'limit'), 'SIGN');
    }

    /**
     * List orders.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orders($params)
    {
        return $this->httpGet('/api/v4/spot/orders', $params, 'SIGN');
    }

    /**
     * Cancel all open orders in specified currency pair.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrders($params)
    {
        return $this->httpDelete('/api/v4/spot/orders', $params, 'SIGN');
    }

    /**
     * Cancel a batch of orders with an ID list.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelBatchOrders($params)
    {
        return $this->httpPostJson('/api/v4/spot/cancel_batch_orders', $params, [], 'SIGN');
    }

    /**
     * Get a single order.
     *
     * @param $order_id
     * @param $currency_pair
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($order_id, $currency_pair)
    {
        return $this->httpGet(sprintf('/api/v4/spot/orders/%s', $order_id), compact('currency_pair'), 'SIGN');
    }

    /**
     * Cancel a single order.
     *
     * @param $order_id
     * @param $currency_pair
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($order_id, $currency_pair)
    {
        return $this->httpDelete(sprintf('/api/v4/spot/orders/%s', $order_id), compact('currency_pair'), 'SIGN');
    }

    /**
     * List personal trading history.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function myTrades($params)
    {
        return $this->httpGet('/api/v4/spot/my_trades', $params, 'SIGN');
    }

    /**
     * Create a price-triggered order.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function priceOrder($params)
    {
        return $this->httpPostJson('/api/v4/spot/price_orders', $params, [], 'SIGN');
    }

    /**
     * Retrieve running auto order list.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function priceOrders($params)
    {
        return $this->httpGet('/api/v4/spot/price_orders', $params, 'SIGN');
    }

    /**
     * Cancel all open orders.
     *
     * @param string $market
     * @param string $account
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelPriceOrders($market = '', $account = '')
    {
        return $this->httpDelete('/api/v4/spot/price_orders', compact('market', 'account'), 'SIGN');
    }
}
