<?php

namespace EasyExchange\Binance\Kernel;

use Psr\Http\Message\RequestInterface;

class BaseClient extends \EasyExchange\Kernel\BaseClient
{
    /**
     * 获取签名.
     *
     * @param array $query
     * @param array $params
     *
     * @return string
     */
    public function getSignature($query = [], $params = [])
    {
        $query = http_build_query($query);
        $params = http_build_query($params);
        $data = $query.$params;
        $secret = $this->app->config->get('secret');

        return hash_hmac('sha256', $data, $secret);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        switch ($this->sign_type) {
            case 'SIGN':
                // signature
                $this->pushMiddleware($this->signatureMiddleware(), 'signature');
                // add app key header
                $this->pushMiddleware($this->addHeaderMiddleware('X-MBX-APIKEY', $this->app->config->get('app_key')), 'add_header');
                break;
            case 'APIKEY':
                // add app key header
                $this->pushMiddleware($this->addHeaderMiddleware('X-MBX-APIKEY', $this->app->config->get('app_key')), 'add_header');
                break;
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

                $sign_params = [
                    'timestamp' => $this->getMs(),
                ];
                $query = array_merge($query, $sign_params);
                if ($params) {
                    $signature = $this->getSignature($query, $params);
                } else {
                    $signature = $this->getSignature($query);
                }

                $query = http_build_query(array_merge($query, ['signature' => $signature]));
                $request = $request->withUri($request->getUri()->withQuery($query));

                return $handler($request, $options);
            };
        };
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
}
