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
        return $this->httpGet('/api/v3/account', compact('recvWindow'), 'SIGN');
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
        return $this->httpGet('/sapi/v1/capital/config/getall', [], 'SIGN');
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
        return $this->httpGet('/sapi/v1/accountSnapshot', $params, 'SIGN');
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
        return $this->httpPost('/sapi/v1/account/disableFastWithdrawSwitch', compact('recvWindow'), 'SIGN');
    }

    /**
     * 开启站内划转.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function enableFastWithdrawSwitch($recvWindow = 60000)
    {
        return $this->httpPost('/sapi/v1/account/enableFastWithdrawSwitch', compact('recvWindow'), 'SIGN');
    }

    /**
     * 提币-Submit a withdraw request.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawApply($params)
    {
        return $this->httpPost('/sapi/v1/capital/withdraw/apply', $params, 'SIGN');
    }

    /**
     * 提币-提交提现请求.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdraw($params)
    {
        return $this->httpPost('/wapi/v3/withdraw.html', $params, 'SIGN');
    }

    /**
     * 获取充值历史(支持多网络).
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositHistory($params)
    {
        return $this->httpGet('/sapi/v1/capital/deposit/hisrec', $params, 'SIGN');
    }
}
