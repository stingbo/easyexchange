<?php

namespace EasyExchange\Binance\Wallet;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 账户信息.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function account($recvWindow = 60000)
    {
        return $this->httpGet('/api/v3/account', compact('recvWindow'), 'TRADE');
    }

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

    /**
     * 查询每日资产快照.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accountSnapshot($params)
    {
        return $this->httpGet('/sapi/v1/accountSnapshot', $params, 'TRADE');
    }

    /**
     * 关闭站内划转.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function disableFastWithdrawSwitch($recvWindow = 60000)
    {
        return $this->httpPost('/sapi/v1/account/disableFastWithdrawSwitch', compact('recvWindow'), 'TRADE');
    }
}
