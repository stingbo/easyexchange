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

    /**
     * 获取资金账户余额信息.
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
        return $this->httpGet('/api/v5/asset/balances', compact('ccy'), 'SIGN');
    }

    /**
     * 资金划转.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transfer($params)
    {
        return $this->httpPostJson('/api/v5/asset/transfer', $params, [], 'SIGN');
    }

    /**
     * 提币.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawal($params)
    {
        return $this->httpPostJson('/api/v5/asset/withdrawal', $params, [], 'SIGN');
    }

    /**
     * 充值记录.
     *
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depositHistory($params = [])
    {
        return $this->httpGet('/api/v5/asset/deposit-history', $params, 'SIGN');
    }

    /**
     * 提币记录.
     *
     * @param array $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawalHistory($params = [])
    {
        return $this->httpGet('/api/v5/asset/withdrawal-history', $params, 'SIGN');
    }

    /**
     * 获取币种列表.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currencies()
    {
        return $this->httpGet('/api/v5/asset/currencies', [], 'SIGN');
    }

    /**
     * 余币宝申购/赎回.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function purchaseRedempt($params)
    {
        return $this->httpPostJson('/api/v5/asset/purchase_redempt', $params, [], 'SIGN');
    }

    /**
     * 资金流水查询.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bills($params)
    {
        return $this->httpGet('/api/v5/asset/bills', $params, 'SIGN');
    }
}
