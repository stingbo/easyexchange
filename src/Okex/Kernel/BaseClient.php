<?php

namespace EasyExchange\Okex\Kernel;

use Psr\Http\Message\RequestInterface;

class BaseClient extends \EasyExchange\Kernel\BaseClient
{
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

        $sign_param = $timestamp.$method.$uri_path.$body;
        $secret = $this->app->config->get('secret');
        $signature = hash_hmac('sha256', $sign_param, $secret, true);

        return base64_encode($signature);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        $this->pushMiddleware($this->addHeaderMiddleware('Content-Type', 'application/json'), 'add_header');
        if ('SIGN' == $this->sign_type) {
            // signature
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
            $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-PASSPHRASE', $this->app->config->get('passphrase')), 'add_header');
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
                $app_key = $this->app->config->get('app_key');
                $timestamp = $this->getRequestDateTime();
                $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-KEY', $app_key), 'add_header');
                $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-TIMESTAMP', $timestamp), 'add_header');

                $method = $request->getMethod();
                $uri_path = $request->getUri()->getPath();
                parse_str($request->getBody()->getContents(), $params);
                parse_str($request->getUri()->getQuery(), $query);
                if ($params) { // POST
                    $signature = $this->getSignature($timestamp, $method, $uri_path, $params);
                } else { // GET
                    $signature = $this->getSignature($timestamp, $method, $uri_path, $query);
                }
                $this->pushMiddleware($this->addHeaderMiddleware('OK-ACCESS-SIGN', $signature), 'add_header');

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

        return date('Y-m-d\TH:i:s'.substr((string)microtime(), 1, 4)).'Z';
    }
}
