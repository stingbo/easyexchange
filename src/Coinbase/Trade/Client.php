<?php

namespace EasyExchange\Coinbase\Trade;

use EasyExchange\Coinbase\Kernel\BaseClient;
use EasyExchange\Kernel\Exceptions\InvalidArgumentException;

class Client extends BaseClient
{
    /**
     * Place a New Order.
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
        return $this->httpPostJson('/orders', $params, [], 'SIGN');
    }

    /**
     * Cancel an Order.
     *
     * @param string $id
     * @param string $client_oid
     * @param string $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws InvalidArgumentException
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrder($id = '', $client_oid = '', $product_id = '')
    {
        if (!$id && !$client_oid) {
            throw new InvalidArgumentException('Order id or client_oid cannot be empty');
        }
        if ($id) {
            $url = sprintf('/orders/%s', $id);
        } elseif ($client_oid) {
            $url = sprintf('/orders/client:%s', $client_oid);
        }

        return $this->httpDelete($url, compact('product_id'), 'SIGN');
    }

    /**
     * Cancel all.
     *
     * @param string $product_id
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelOrders($product_id = '')
    {
        return $this->httpDelete('/orders', compact('product_id'), 'SIGN');
    }

    /**
     * List Orders.
     *
     * @param $params
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orders($params)
    {
        return $this->httpGet('/orders', $params, 'SIGN');
    }

    /**
     * Get an Order.
     *
     * @param string $id
     * @param string $client_oid
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws InvalidArgumentException
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($id = '', $client_oid = '')
    {
        if (!$id && !$client_oid) {
            throw new InvalidArgumentException('Order id or client_oid cannot be empty');
        }
        if ($id) {
            $url = sprintf('/orders/%s', $id);
        } elseif ($client_oid) {
            $url = sprintf('/orders/client:%s', $client_oid);
        }

        return $this->httpGet($url, [], 'SIGN');
    }
}
