<?php

namespace EasyExchange\Binance\Kernel;

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
                parse_str($request->getBody()->getContents(), $params);
                parse_str($request->getUri()->getQuery(), $query);
                if ($params) {
                    $signature = $this->getSignature($params);
                } else {
                    $signature = $this->getSignature($query);
                }

                $query = http_build_query(array_merge($query, ['signature' => $signature]));
                $request = $request->withUri($request->getUri()->withQuery($query));

                return $handler($request, $options);
            };
        };
    }
}
