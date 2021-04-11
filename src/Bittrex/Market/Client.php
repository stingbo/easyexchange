<?php

namespace EasyExchange\Bittrex\Market;

use EasyExchange\Bittrex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * markets - List markets.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function markets()
    {
        return $this->httpGet('/v3/markets');
    }
}
