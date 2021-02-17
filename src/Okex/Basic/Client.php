<?php

namespace EasyExchange\Okex\Basic;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取当前系统时间戳.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function systemTime()
    {
        return $this->httpGet('/api/v5/public/time');
    }

    /**
     * 获取所有可交易产品的信息列表.
     *
     * @param $instType
     * @param string $uly
     * @param string $instId
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exchangeInfo($instType, $uly = '', $instId = '')
    {
        return $this->httpGet('/api/v5/public/instruments', compact('instType', 'uly', 'instId'));
    }
}
