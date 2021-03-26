<?php

namespace EasyExchange\Gate\Delivery;

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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/contracts', $settle));
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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/contracts/%s', $settle, $contract));
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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/order_book', $settle), $params);
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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/trades', $settle), $params);
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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/candlesticks', $settle), $params);
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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/tickers', $settle), compact('contract'));
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
        return $this->httpGet(sprintf('/api/v4/delivery/%s/insurance', $settle), compact('limit'));
    }

    /**
     * Query futures account.
     *
     * @param $settle
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accounts($settle)
    {
        return $this->httpGet(sprintf('/api/v4/delivery/%s/accounts', $settle), [], 'SIGN');
    }

    /**
     * Query account book.
     *
     * @param $settle
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accountHistory($settle, $params = [])
    {
        return $this->httpGet(sprintf('/api/v4/delivery/%s/account_book', $settle), $params, 'SIGN');
    }

    /**
     * List all positions of a user.
     *
     * @param $settle
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function positions($settle)
    {
        return $this->httpGet(sprintf('/api/v4/delivery/%s/positions', $settle), [], 'SIGN');
    }

    /**
     * Get single position.
     *
     * @param $settle
     * @param $contract
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function position($settle, $contract)
    {
        return $this->httpGet(sprintf('/api/v4/delivery/%s/positions/%s', $settle, $contract), [], 'SIGN');
    }
}
