<?php

namespace EasyExchange\Binance\Trade;

use EasyExchange\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 测试下单.
     *
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderTest($params)
    {
        return $this->httpPost('/api/v3/order/test', $params);
    }

    /**
     * 下单.
     *
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($params)
    {
        return $this->httpPost('/api/v3/order', $params);
    }
}
