<?php

namespace EasyExchange\Okex\Market;

use EasyExchange\Okex\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取产品深度.
     *
     * @param $instId
     * @param int $sz
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function depth($instId, $sz = 1)
    {
        return $this->httpGet('/api/v5/market/books', compact('instId', 'sz'));
    }
}
