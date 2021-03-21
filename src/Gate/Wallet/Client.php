<?php

namespace EasyExchange\Gate\Wallet;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Generate currency deposit address.
     *
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositAddress($currency)
    {
        return $this->httpGet('/api/v4/wallet/deposit_address', compact('currency'), 'SIGN');
    }
}
