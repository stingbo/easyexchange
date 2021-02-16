<?php

namespace EasyExchange\Binance\Wallet;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取所有币信息.
     * No sapi/wapi in testnet; only api endpoints available.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        return $this->httpGet('/sapi/v1/capital/config/getall', [], 'TRADE');
    }
}
