<?php

namespace EasyExchange\Huobi\Wallet;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get all Accounts of the Current User.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accounts()
    {
        return $this->httpGet('/v1/account/accounts', [], 'TRADE');
    }
}
