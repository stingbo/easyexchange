<?php

namespace EasyExchange\Kernel;

use EasyExchange\Kernel\Traits\HasHttpRequests;
use Psr\Http\Message\RequestInterface;

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
     * @var null
     */
    protected $sign_type = 'NONE';

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
        if (empty($this->middlewares)) {
            $this->registerHttpMiddlewares();
        }

        $response = $this->performRequest($url, $method, $options);

        return $returnRaw ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }

    /**
     * GET request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyExchange\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet(string $url, array $query = [], $sign_type = 'NONE')
    {
        $this->sign_type = $sign_type;

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
    public function httpPost(string $url, array $data = [], $sign_type = 'NONE')
    {
        $this->sign_type = $sign_type;

        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * JSON request.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyExchange\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyExchange\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    /**
     * 获取签名.
     *
     * @param $params
     *
     * @return string
     */
    public function getSignature($params)
    {
        $data = http_build_query($params);
        $secret = $this->app->config->get('secret');

        return hash_hmac('SHA256', $data, $secret);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        if ('TRADE' == $this->sign_type) {
            // signature
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
            // add app key header
            $this->pushMiddleware($this->addHeaderMiddleware('X-MBX-APIKEY', $this->app->config->get('app_key')), 'add_header');
        }
    }

    /**
     * Attache signature to request query.
     *
     * @return \Closure
     */
    protected function signatureMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                parse_str($request->getBody()->getContents(), $query);
                $signature = $this->getSignature($query);
                $query = http_build_query(['signature' => $signature]);
                $request = $request->withUri($request->getUri()->withQuery($query));

                return $handler($request, $options);
            };
        };
    }

    /**
     * 增加header.
     *
     * @param $header
     * @param $value
     *
     * @return \Closure
     */
    protected function addHeaderMiddleware($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (RequestInterface $request, array $options) use ($handler, $header, $value) {
                $request = $request->withHeader($header, $value);

                return $handler($request, $options);
            };
        };
    }
}
