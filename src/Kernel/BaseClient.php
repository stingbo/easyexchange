<?php

namespace EasyExchange\Kernel;

use EasyExchange\Kernel\Traits\HasHttpRequests;

class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }

    /**
     * @var \EasyExchange\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * BaseClient constructor.
     *
     * @param \EasyExchange\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param bool $returnRaw
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyExchange\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        return $this->performRequest($url, $method, $options);
    }

    /**
     * GET request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyExchange\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * POST request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyExchange\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }
}
