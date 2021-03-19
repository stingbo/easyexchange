<?php

namespace EasyExchange\Okex\User;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 查看账户余额.
     *
     * @param string $ccy
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function balance($ccy = '')
    {
        return $this->httpGet('/api/v5/account/balance', compact('ccy'), 'SIGN');
    }
}
