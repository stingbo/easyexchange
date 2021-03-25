<?php

namespace EasyExchange\Gate\Delivery;

use EasyExchange\Gate\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * List all futures contracts.
     *
     * @param $settle
     *
     * @return array|\EasyExchange\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contracts($settle)
    {
        return $this->httpGet(sprintf('/api/v4/delivery/%s/contracts', $settle));
    }
}
