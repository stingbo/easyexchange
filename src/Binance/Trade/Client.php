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
        $params['timestamp'] = $this->getMs();
        ksort($params);
        $data = http_build_query($params);
        $secret = $this->app->config->get('secret');
        $signature = hash_hmac('SHA256', $data, $secret);
        $params['signature'] = $signature;

        return $this->httpPost('/api/v3/order', $params);
    }
}
