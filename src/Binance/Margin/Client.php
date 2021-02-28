<?php

namespace EasyExchange\Binance\Margin;

use EasyExchange\Binance\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 全仓杠杆账户划转.
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
        return $this->httpPost('/sapi/v1/margin/transfer', $params, 'TRADE');
    }

    /**
     * 杠杆账户借贷.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loan($params)
    {
        return $this->httpPost('/sapi/v1/margin/loan', $params, 'TRADE');
    }

    /**
     * 杠杆账户归还借贷.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repay($params)
    {
        return $this->httpPost('/sapi/v1/margin/repay', $params, 'TRADE');
    }

    /**
     * 查询杠杆资产.
     *
     * @param $asset
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function asset($asset)
    {
        return $this->httpPost('/sapi/v1/margin/asset', compact('asset'), 'TRADE');
    }
}
