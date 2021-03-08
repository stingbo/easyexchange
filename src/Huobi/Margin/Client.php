<?php

namespace EasyExchange\Huobi\Margin;

use EasyExchange\Huobi\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 归还借币（全仓逐仓通用）.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repayment($params)
    {
        return $this->httpPostJson('/v2/account/repayment', $params, [], 'SIGN');
    }
}
