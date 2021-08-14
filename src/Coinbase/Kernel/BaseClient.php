<?php

namespace EasyExchange\Coinbase\Kernel;

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

        return base64_encode(hash_hmac('sha256', $this->message, base64_decode($secret), true));
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        $this->pushMiddleware($this->addHeaderMiddleware('Content-Type', 'application/json'), 'add_header_content_type');
        if ('SIGN' == $this->sign_type) {
            $this->pushMiddleware($this->addHeaderMiddleware('CB-ACCESS-KEY', $this->app->config->get('app_key')), 'add_header_appkey');
            $this->pushMiddleware($this->addHeaderMiddleware('CB-ACCESS-PASSPHRASE', $this->app->config->get('passphrase')), 'add_header_passphrase');
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
        }

        // proxy
        $this->pushMiddleware($this->proxyMiddleware(), 'proxy');

        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');
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
                $this->timestamp = $this->getRequestDateTime();
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
                $request = $request->withHeader('CB-ACCESS-SIGN', $signature);
                $request = $request->withHeader('CB-ACCESS-TIMESTAMP', $this->timestamp);

                return $handler($request, $options);
            };
        };
    }

    /**
     * A timestamp for your request.
     *
     * @return int
     */
    public function getRequestDateTime()
    {
        return time();
    }
}
