<?php

namespace EasyExchange\Gate\Kernel;

use Psr\Http\Message\RequestInterface;

class BaseClient extends \EasyExchange\Kernel\BaseClient
{
    public $timestamp;

    /**
     * 获取签名.
     *
     * @param $params
     *
     * @return string
     */
    public function getSignature($query, $body, $method, $uri_path)
    {
        $data = hash('sha512', (null !== $body) ? $body : '');
        $sign_param = $method."\n".$uri_path."\n".$query."\n".$data."\n".$this->timestamp;
        $secret = $this->app->config->get('secret');

        return hash_hmac('sha512', $sign_param, $secret);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        $this->pushMiddleware($this->addHeaderMiddleware('Content-Type', 'application/json'), 'add_header_content_type');
        if ('SIGN' == $this->sign_type) {
            // signature
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
        }

        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');

        // proxy
        $this->pushMiddleware($this->proxyMiddleware(), 'proxy');
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
                $key = $this->app->config->get('app_key');
                $this->timestamp = time();
                $method = $request->getMethod();
                $uri_path = $request->getUri()->getPath();
                $query = $request->getUri()->getQuery();
                $body = $request->getBody();
                $signature = $this->getSignature($query, $body, $method, $uri_path);

                $request = $request->withHeader('KEY', $key);
                $request = $request->withHeader('Timestamp', $this->timestamp);
                $request = $request->withHeader('SIGN', $signature);

                return $handler($request, $options);
            };
        };
    }
}
