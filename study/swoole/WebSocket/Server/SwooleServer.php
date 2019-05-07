<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-27
 * Time: 下午4:21
 */

namespace WebSocket\Server;

use WebSocket\Base\Loader;
use WebSocket\Base\Response;
use WebSocket\Base\Util;
use WebSocket\Service\MessageService;
use WebSocket\Service\UserService;
use swoole_http_request;
use swoole_websocket_frame;
use swoole_websocket_server;
use swoole_http_response;

class SwooleServer
{
    /**
     * 单例
     * @var
     */
    private static $instance;

    /**
     * swoole server object
     * @var
     */
    private $server;

    /**
     *
     * @var
     */
    private $user;

    /**
     *
     * @var
     */
    private $message;

    /**
     * 启动开始时间
     * @var
     */
    private $startTime;

    /**
     * SwooleServer constructor.
     * @param $ip
     * @param $port
     */
    private function __construct($ip, $port)
    {
        Loader::redis(true);
        $this->server = new swoole_websocket_server($ip, $port);
        $this->user = Loader::user();
        $this->message = Loader::message();
    }

    /**
     * 获取单例
     * @return mixed
     */
    public static function getInstance(): self
    {
        $ip = Loader::config()->getServerConnectInfo()['ip'];
        $port = Loader::config()->getServerConnectInfo()['port'];
        // $keys = md5("{$ip},{$port}");
        if (empty(self::$instance)) {
            self::$instance = new self($ip, $port);
            self::$instance->startTime = date('YmdHis');
        }

        return self::$instance;
    }

    /**
     * 启动服务
     */
    public function start()
    {
        $server = $this->server;

        /**
         * 用户接入
         */
        $server->on('open', function (swoole_websocket_server $ws, swoole_http_request $request) {
            Util::ps('open', "用户接入fd:{$request->fd}");

            try {
                //  接收请求参数
                $params = $request->get;

                //  参数鉴权
                Loader::auth()->verify($params);

                //  连贯操作 绑定用户监听器 推送消息 释放监听器
                $this->bindUserListener($request->fd, $params['client_id'])
                    ->push($request->fd, Loader::response($params));

            } catch (\Exception $exception) {
                //  记录错误信息
                Util::ps('open', "用户接入错误信息:".$exception->getMessage()."|".$exception->getFile().$exception->getLine());

                $this->unbindUserListener($request->fd);
            }
        });

        /**
         * 收到socket消息
         */
        $server->on('message', function (swoole_websocket_server $ws, swoole_websocket_frame $frame) {
            Util::ps('message', "用户socket消息fd:{$frame->fd}");
        });

        $server->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($server) {
            Loader::redis(true);
            try {
                //  接收请求参数
                $params = property_exists($request, 'post') ? $request->post : (property_exists($request, 'get') ? $request->get : []);

                Util::ps('request', "http请求:" . json_encode([$params]));

                //  参数鉴权
                Loader::auth()->verify($params);

                switch ($params['service']) {
                    case Loader::config()::SERVICE_MESSAGE:
                        $this->message->push($params['client_id'], Loader::response($params), $this->user, $this->server);
                        break;

                    case Loader::config()::USER_ONLINE_COUNT:
                        $this->user->getOnlineCount($params['client_id'], $this->server);
                        break;

                    default:
                        throw new \Exception('未知操作');
                        break;
                }

                // $server->push('1', json_encode(['code' => '1', 'message' => '测试消息内容', 'data' => $params['data']], JSON_UNESCAPED_UNICODE));


                $response->end("<h1>Hello Swoole. #" . rand(1000, 9999) . "</h1>");
            } catch (\Exception $exception) {
                //  记录错误信息
                Util::ps('request', "http请求:" . $exception->getMessage());
            }

        });

        /**
         * 关闭链接
         */
        $server->on('close', function ($ws, $fd) {
            Util::ps('close', "关闭链接,fd:{$fd}");
            //  解除绑定
            $this->user->unbind($fd);
        });

        /**
         * 启动服务
         */
        $server->on('start', function ($ws) {
            Util::ps('start', '启动服务');
        });

        $server->start();
    }

    /**
     * 绑定用户监听器
     * @param $fd
     * @param $clientId
     * @return SwooleServer
     */
    private function bindUserListener($fd, $clientId): self
    {
        $this->user->bind($fd, $clientId);

        return $this;
    }

    /**
     * 消息推送
     * @param $fd
     * @param Response $response
     * @return $this
     */
    private function push($fd, Response $response)
    {
        $this->server->push($fd, $response->toJson());

        return $this;
    }

    /**
     * 用户释放监听器
     * @param $fd
     * @return $this
     */
    private function unbindUserListener($fd)
    {
        $this->server->close($fd);

        return $this;
    }

}