<?php

namespace EasyExchange\Binance\Pool;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取算法.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function algoList($recvWindow = 60000)
    {
        return $this->httpGet('/sapi/v1/mining/pub/algoList', compact('recvWindow'), 'SIGN');
    }
}