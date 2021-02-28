<?php

namespace EasyExchange\Binance\User;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取BNB抵扣开关状态.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBnbBurnStatus($recvWindow = 60000)
    {
        return $this->httpGet('/sapi/v1/bnbBurn', compact('recvWindow'), 'SIGN');
    }

    /**
     * 现货交易和杠杆利息BNB抵扣开关.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bnbBurn($params)
    {
        return $this->httpPost('/sapi/v1/bnbBurn', $params, 'SIGN');
    }
}
