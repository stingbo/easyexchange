<?php

namespace EasyExchange\Okex\Wallet;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取充值地址信息.
     *
     * @param $ccy
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositAddress($ccy)
    {
        return $this->httpGet('/api/v5/asset/deposit-address', compact('ccy'), 'SIGN');
    }
}
