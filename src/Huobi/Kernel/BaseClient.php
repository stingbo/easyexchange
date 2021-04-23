<?php

namespace EasyExchange\Huobi\Kernel;

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
        ksort($params);
        $data = http_build_query($params);

        $sign_param = $method."\n".$uri_host."\n".$uri_path."\n".$data;
        $secret = $this->app->config->get('secret');
        $signature = hash_hmac('sha256', $sign_param, $secret, true);

        return base64_encode($signature);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        if ('SIGN' == $this->sign_type) {
            // signature
            $this->pushMiddleware($this->signatureMiddleware(), 'signature');
        }

        // proxy
        $this->pushMiddleware($this->proxyMiddleware(), 'proxy');

        // log
        $this->pushMiddleware($this->logMiddleware(), 'log');
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
                $method = $request->getMethod();
                $uri_host = $request->getUri()->getHost();
                $uri_path = $request->getUri()->getPath();
                parse_str($request->getBody()->getContents(), $params);
                parse_str($request->getUri()->getQuery(), $query);

                date_default_timezone_set('UTC');
                $sign_params = [
                    'AccessKeyId' => $this->app->config->get('app_key'),
                    'SignatureMethod' => 'HmacSHA256',
                    'SignatureVersion' => 2,
                    'Timestamp' => date('Y-m-d\TH:i:s'),
                ];

                // For GET request, all the parameters must be signed.
                $query = array_merge($query, $sign_params);
                if ($params) {
                    // For POST request, the parameters needn't be signed and they should be put in request body.
                    $params = array_merge([], $sign_params);
                    $signature = $this->getSignature($params, $method, $uri_host, $uri_path);
                } else {
                    $signature = $this->getSignature($query, $method, $uri_host, $uri_path);
                }

                $query = http_build_query(array_merge($query, ['Signature' => $signature]));
                $request = $request->withUri($request->getUri()->withQuery($query));

                return $handler($request, $options);
            };
        };
    }
}
