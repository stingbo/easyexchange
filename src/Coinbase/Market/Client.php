<?php

namespace EasyExchange\Coinbase\Market;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get Products - Get a list of available currency pairs for trading.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function products()
    {
        return $this->httpGet('/products');
    }

    /**
     * Get Single Product - Get market data for a specific currency pair.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function product($product_id)
    {
        return $this->httpGet(sprintf('/products/%s', $product_id));
    }

    /**
     * Get Product Order Book - Get a list of open orders for a product. The amount of detail shown can be customized with the level parameter.
     *
     * @param $product_id
     * @param int $level
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($product_id, $level = 1)
    {
        return $this->httpGet(sprintf('/products/%s/book', $product_id), compact('level'));
    }

    /**
     * Get Product Ticker - Snapshot information about the last trade (tick), best bid/ask and 24h volume.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tickers($product_id)
    {
        return $this->httpGet(sprintf('/products/%s/ticker', $product_id));
    }

    /**
     * Get Trades - List the latest trades for a product.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trades($product_id)
    {
        return $this->httpGet(sprintf('/products/%s/trades', $product_id));
    }

    /**
     * Get Historic Rates - Historic rates for a product. Rates are returned in grouped buckets based on requested granularity.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kline($product_id)
    {
        return $this->httpGet(sprintf('/products/%s/candles', $product_id));
    }

    /**
     * Get 24hr Stats - Get 24 hr stats for the product. volume is in base currency units. open, high, low are in quote currency units.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hr24($product_id)
    {
        return $this->httpGet(sprintf('/products/%s/stats', $product_id));
    }

    /**
     * Get currencies - List known currencies.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currencies()
    {
        return $this->httpGet('/currencies');
    }
}
