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
}
