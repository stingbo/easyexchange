<?php

namespace EasyExchange\Okex\Trading;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get support coin.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function supportCoin()
    {
        return $this->httpGet('/api/v5/rubik/stat/trading-data/support-coin');
    }

    /**
     * Get taker volume.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function takerVolume($params)
    {
        return $this->httpGet('/api/v5/rubik/stat/taker-volume', $params);
    }

    /**
     * Get margin lending ratio.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loadRatio($params)
    {
        return $this->httpGet('/api/v5/rubik/stat/margin/loan-ratio', $params);
    }

    /**
     * Get contracts long/short ratio.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contractLongShortAccountRatio($params)
    {
        return $this->httpGet('/api/v5/rubik/stat/contracts/long-short-account-ratio', $params);
    }

    /**
     * Get contracts open interest and volume.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contractOpenInterestVolume($params)
    {
        return $this->httpGet('/api/v5/rubik/stat/contracts/open-interest-volume', $params);
    }

    /**
     * Get options open interest and volume.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function optionOpenInterestVolume($params)
    {
        return $this->httpGet('/api/v5/rubik/stat/option/open-interest-volume', $params);
    }
}
