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
        return $this->httpPost('/sapi/v1/margin/transfer', $params, 'SIGN');
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
        return $this->httpPost('/sapi/v1/margin/loan', $params, 'SIGN');
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
        return $this->httpPost('/sapi/v1/margin/repay', $params, 'SIGN');
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
        return $this->httpGet('/sapi/v1/margin/asset', compact('asset'), 'APIKEY');
    }

    /**
     * 获取所有杠杆资产信息.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function allAssets()
    {
        return $this->httpGet('/sapi/v1/margin/allAssets', [], 'APIKEY');
    }

    /**
     * 查询全仓杠杆交易对.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pair($symbol)
    {
        return $this->httpGet('/sapi/v1/margin/pair', compact('symbol'), 'APIKEY');
    }

    /**
     * 获取所有全仓杠杆交易对.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function allPairs()
    {
        return $this->httpGet('/sapi/v1/margin/allPairs', [], 'APIKEY');
    }
}
