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

    /**
     * 查询杠杆价格指数.
     *
     * @param $symbol
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function priceIndex($symbol)
    {
        return $this->httpGet('/sapi/v1/margin/priceIndex', compact('symbol'), 'APIKEY');
    }

    /**
     * 杠杆账户下单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($params)
    {
        return $this->httpPost('/sapi/v1/margin/order', $params, 'SIGN');
    }

    /**
     * 杠杆账户撤销订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($params)
    {
        return $this->httpDelete('/sapi/v1/margin/order', $params, 'SIGN');
    }

    /**
     * 杠杆账户撤销单一交易对的所有挂单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrders($params)
    {
        return $this->httpDelete('/sapi/v1/margin/openOrders', $params, 'SIGN');
    }

    /**
     * 获取全仓杠杆划转历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transferHistory($params)
    {
        return $this->httpGet('/sapi/v1/margin/transfer', $params, 'SIGN');
    }

    /**
     * 查询借贷记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loanHistory($params)
    {
        return $this->httpGet('/sapi/v1/margin/loan', $params, 'SIGN');
    }

    /**
     * 查询还贷记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function repayHistory($params)
    {
        return $this->httpGet('/sapi/v1/margin/repay', $params, 'SIGN');
    }

    /**
     * 获取利息历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function interestHistory($params)
    {
        return $this->httpGet('/sapi/v1/margin/interestHistory', $params, 'SIGN');
    }

    /**
     * 获取账户强制平仓记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function forceLiquidationRec($params)
    {
        return $this->httpGet('/sapi/v1/margin/forceLiquidationRec', $params, 'SIGN');
    }

    /**
     * 查询全仓杠杆账户详情.
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
        return $this->httpGet('/sapi/v1/margin/account', compact('recvWindow'), 'SIGN');
    }

    /**
     * 查询杠杆账户订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($params)
    {
        return $this->httpGet('/sapi/v1/margin/order', $params, 'SIGN');
    }

    /**
     * 查询杠杆账户挂单记录.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openOrders($params)
    {
        return $this->httpGet('/sapi/v1/margin/openOrders', $params, 'SIGN');
    }

    /**
     * 查询杠杆账户的所有订单.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function allOrders($params)
    {
        return $this->httpGet('/sapi/v1/margin/allOrders', $params, 'SIGN');
    }

    /**
     * 查询杠杆账户交易历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function myTrades($params)
    {
        return $this->httpGet('/sapi/v1/margin/myTrades', $params, 'SIGN');
    }

    /**
     * 查询账户最大可借贷额度.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function maxBorrowable($params)
    {
        return $this->httpGet('/sapi/v1/margin/maxBorrowable', $params, 'SIGN');
    }

    /**
     * 查询最大可转出额.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function maxTransferable($params)
    {
        return $this->httpGet('/sapi/v1/margin/maxTransferable', $params, 'SIGN');
    }

    /**
     * 创建杠杆逐仓账户.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($params)
    {
        return $this->httpPost('/sapi/v1/margin/isolated/create', $params, 'SIGN');
    }

    /**
     * 杠杆逐仓账户划转.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isolatedTransfer($params)
    {
        return $this->httpPost('/sapi/v1/margin/isolated/transfer', $params, 'SIGN');
    }

    /**
     * 获取杠杆逐仓划转历史.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isolatedTransferHistory($params)
    {
        return $this->httpGet('/sapi/v1/margin/isolated/transfer', $params, 'SIGN');
    }

    /**
     * 查询杠杆逐仓账户信息.
     *
     * @param string $symbol
     * @param int    $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isolatedAccount($symbol = '', $recvWindow = 60000)
    {
        $request = [];
        if ($symbol) {
            $request['symbol'] = $symbol;
        }
        if ($recvWindow) {
            $request['recvWindow'] = $recvWindow;
        }

        return $this->httpGet('/sapi/v1/margin/isolated/account', $request, 'SIGN');
    }

    /**
     * 查询逐仓杠杆交易对.
     *
     * @param string $symbol
     * @param int    $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isolatedPair($symbol, $recvWindow = 60000)
    {
        return $this->httpGet('/sapi/v1/margin/isolated/pair', compact('symbol', 'recvWindow'), 'SIGN');
    }

    /**
     * 获取所有逐仓杠杆交易对.
     *
     * @param int $recvWindow
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isolatedAllPairs($recvWindow = 60000)
    {
        return $this->httpGet('/sapi/v1/margin/isolated/allPairs', compact('recvWindow'), 'SIGN');
    }

    /**
     * Query Margin Interest Rate History.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function interestRateHistory($params)
    {
        return $this->httpGet('/sapi/v1/margin/interestRateHistory', $params, 'SIGN');
    }
}
