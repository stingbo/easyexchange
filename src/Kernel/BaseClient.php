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
    protected $signature = null;

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
     * 获取当前毫秒.
     *
     * @return float
     */
    public function getMs()
    {
        list($ms, $sec) = explode(' ', microtime());

        return (float) sprintf('%.0f', (floatval($ms) + floatval($sec)) * 1000);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        // signature
//        $this->pushMiddleware($this->signatureMiddleware(), 'signature');

        // add header
        $this->pushMiddleware($this->addHeaderMiddleware('X-MBX-APIKEY', $this->app->config->get('app_key')), 'add_header');
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
                return $handler($request, $options);
            };
        };
    }

    protected function addHeaderMiddleware($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (RequestInterface $request, array $options) use ($handler, $header, $value) {
                parse_str($request->getBody()->getContents(), $body);
                if (isset($body['signature']) && $body['signature']) {
                    $request = $request->withHeader($header, $value);
                }

                return $handler($request, $options);
            };
        };
    }
}
