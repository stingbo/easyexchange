<?php

namespace EasyExchange\Gate\Future;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * List all futures contracts.
     *
     * @param $settle
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contracts($settle)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/contracts', $settle));
    }

    /**
     * Get a single contract.
     *
     * @param $settle
     * @param $contract
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contract($settle, $contract)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/contracts/%s', $settle, $contract));
    }

    /**
     * Futures order book.
     *
     * @param $settle
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($settle, $params)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/order_book', $settle), $params);
    }

    /**
     * Futures trading history.
     *
     * @param $settle
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trades($settle, $params)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/trades', $settle), $params);
    }

    /**
     * Get futures candlesticks.
     *
     * @param $settle
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function kline($settle, $params)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/candlesticks', $settle), $params);
    }

    /**
     * List futures tickers.
     *
     * @param $settle
     * @param $contract
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tickers($settle, $contract)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/tickers', $settle), compact('contract'));
    }

    /**
     * Funding rate history.
     *
     * @param $settle
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fundingRateHistory($settle, $params)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/funding_rate', $settle), $params);
    }

    /**
     * Futures insurance balance history.
     *
     * @param $settle
     * @param string $limit
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function insuranceHistory($settle, $limit = '')
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/insurance', $settle), compact('limit'));
    }

    /**
     * Futures stats.
     *
     * @param $settle
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contractStats($settle, $params)
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/contract_stats', $settle), $params);
    }

    /**
     * Retrieve liquidation history.
     *
     * @param $settle
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function liquidationOrders($settle, $params = [])
    {
        return $this->httpGet(sprintf('/api/v4/futures/%s/liq_orders', $settle), $params);
    }
}
