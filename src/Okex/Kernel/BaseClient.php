<?php

namespace EasyExchange\Okex\Kernel;

use Psr\Http\Message\RequestInterface;

class BaseClient extends \EasyExchange\Kernel\BaseClient
{
    public $timestamp;

    public $message;

    /**
     * 获取签名.
     *
     * @param $params
     *
     * @return string
     */
    public function getSignature($timestamp, $method = '', $uri_path = '', $params = [])
    {
        if ('GET' == $method) {
            $uri_path .= $params ? '?'.http_build_query($params) : '';
            $params = [];
        }
        $body = $params ? json_encode($params, JSON_UNESCAPED_SLASHES) : '';

        $this->message = (string) $timestamp.$method.$uri_path.(string) $body;
        $secret = $this->app->config->get('secret');

        return base64_encode(hash_hmac('sha256', $this->message, $secret, true));
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        $this->pushMiddleware($this->addHeaderMiddleware('Content-Type', 'application/json'), 'add_header_content_type');
        $this->pushMiddleware($this->addHeaderMiddleware('x-simulated-trading', $this->app->config->get('x-simulated-trading')), 'add_header_test');
        if ('SIGN' == $this->sign_type) {
            // signature
            $this->timestamp = $this->getRequestDateTime();
            $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-KEY', $this->app->config->get('app_key')), 'add_header_appkey');
            $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-TIMESTAMP', $this->timestamp), 'add_header_timestamp');
            $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-PASSPHRASE', $this->app->config->get('passphrase')), 'add_header_passphrase');
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
        }

        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');

        // proxy
        $this->pushMiddleware($this->proxyMiddleware(), 'proxy');
    }

    /**
     * Attache signature to request header.
     *
     * @return \Closure
     */
    protected function signatureMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $method = $request->getMethod();
                $uri_path = $request->getUri()->getPath();
                if ('POST' == $method) { // POST
                    $body = $request->getBody();
                    $params = json_decode($body, true);
                    $signature = $this->getSignature($this->timestamp, $method, $uri_path, $params);
                } else { // GET
                    parse_str($request->getUri()->getQuery(), $query);
                    $signature = $this->getSignature($this->timestamp, $method, $uri_path, $query);
                }
                $request = $request->withHeader('OK-ACCESS-SIGN', $signature);

                return $handler($request, $options);
            };
        };
    }

    /**
     * UTC ISO格式时间.
     *
     * @return float
     */
    public function getRequestDateTime()
    {
        date_default_timezone_set('UTC');

        return date('Y-m-d\TH:i:s'.substr((string) microtime(), 1, 4)).'Z';
    }
}
