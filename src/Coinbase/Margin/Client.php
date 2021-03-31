<?php

namespace EasyExchange\Coinbase\Margin;

use EasyExchange\Coinbase\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get margin profile information.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function profileInformation($product_id)
    {
        return $this->httpGet('/margin/profile_information', compact('product_id'), 'SIGN');
    }

    /**
     * Get buying power or selling power.
     *
     * @param $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function buyingPower($product_id)
    {
        return $this->httpGet('/margin/buying_power', compact('product_id'), 'SIGN');
    }

    /**
     * Get withdrawal power.
     *
     * @param $currency
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawalPower($currency)
    {
        return $this->httpGet('/margin/withdrawal_power', compact('currency'), 'SIGN');
    }

    /**
     * Get all withdrawal powers.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withdrawalPowers()
    {
        return $this->httpGet('/margin/withdrawal_power_all', [], 'SIGN');
    }

    /**
     * Get exit plan.
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exitPlan()
    {
        return $this->httpGet('/margin/exit_plan', [], 'SIGN');
    }

    /**
     * List liquidation history.
     *
     * @param string $after
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function liquidationHistory($after = '')
    {
        return $this->httpGet('/margin/liquidation_history', compact('after'), 'SIGN');
    }
}
