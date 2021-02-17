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
    public function getSignature($params = [], $method = '', $uri_host = '', $uri_path = '')
    {
        return true;
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        if ('TRADE' == $this->sign_type) {
            // signature
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
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
                return $handler($request, $options);
            };
        };
    }
}
