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
}
