<?php

namespace EasyExchange\Okex\User;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 查看账户余额.
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
        return $this->httpGet('/api/v5/account/balance', compact('ccy'), 'SIGN');
    }

    /**
     * 查看持仓信息.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function positions($params)
    {
        return $this->httpGet('/api/v5/account/positions', $params, 'SIGN');
    }

    /**
     * 账单流水查询（近七天）.
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
        return $this->httpGet('/api/v5/account/bills', $params, 'SIGN');
    }

    /**
     * 账单流水查询（近三个月）.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function billsArchive($params)
    {
        return $this->httpGet('/api/v5/account/bills-archive', $params, 'SIGN');
    }

    /**
     * 查看账户配置.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function config()
    {
        return $this->httpGet('/api/v5/account/config', [], 'SIGN');
    }

    /**
     * 设置持仓模式.
     *
     * @param $posMode
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setPositionMode($posMode)
    {
        return $this->httpPostJson('/api/v5/account/set-position-mode', compact('posMode'), [], 'SIGN');
    }

    /**
     * 设置杠杆倍数.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setLeverage($params)
    {
        return $this->httpPostJson('/api/v5/account/set-leverage', $params, [], 'SIGN');
    }

    /**
     * 获取最大可买卖/开仓数量.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function maxSize($params)
    {
        return $this->httpGet('/api/v5/account/max-size', $params, 'SIGN');
    }

    /**
     * 获取最大可用数量.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function maxAvailSize($params)
    {
        return $this->httpGet('/api/v5/account/max-avail-size', $params, 'SIGN');
    }

    /**
     * 调整保证金.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function marginBalance($params)
    {
        return $this->httpPostJson('/api/v5/account/position/margin-balance', $params, [], 'SIGN');
    }

    /**
     * 获取杠杆倍数.
     *
     * @param $instId
     * @param $mgnMode
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function leverageInfo($instId, $mgnMode)
    {
        return $this->httpGet('/api/v5/account/leverage-info', compact('instId', 'mgnMode'), 'SIGN');
    }
}
