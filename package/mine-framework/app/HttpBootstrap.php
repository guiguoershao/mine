<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-17
 * Time: 下午3:45
 */

namespace App;
use guiguoershao\Container\Container;
use guiguoershao\Http\Http;
use guiguoershao\Protocol\IBootstrap;
class HttpBootstrap implements IBootstrap
{
    private $request;

    public function __construct(\Swoole\Http\Request $request)
    {
        $this->request = $request;
    }

    /**
     * 启动初始化
     * @param Container $container
     * @return Container
     */
    public function boot(Container $container)
    {
        $request = $this->request;
        $container->register(Http::class, function () use ($request) {
            $server = $request->server;
            $post = empty($request->post) ? [] : $request->post;
            $get = empty($request->get) ? [] : $request->get;
            $cookie = empty($request->cookie) ? [] : $request->cookie;
            $header = empty($request->header) ? [] : $request->header;
            foreach ($server as $key=>$value) {
                $server[strtoupper($key)] = $value;
            }
            foreach ($cookie as $key=>$value) {
                $cookie[strtoupper($key)] = $value;
            }
            foreach ($header as $key=>$value) {
                $header[strtoupper($key)] = $value;
            }
//            var_dump($server, $cookie, $header, array_merge($post, $get));
            return new Http($server, $cookie, $header, array_merge($post, $get));
        })->resolverProviders([
            'app' => \App\Providers\AppProvider::class,
            'route' => \App\Providers\RouteProvider::class,
        ]);

        return $container;
    }
}