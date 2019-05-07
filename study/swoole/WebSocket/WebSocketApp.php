<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2018/9/26
 * Time: 下午11:06
 */

namespace WebSocket;


use WebSocket\Base\Config;
use WebSocket\Base\Loader;
use WebSocket\Client\Request;
use WebSocket\Server\SwooleServer;

class WebSocketApp
{

    /**
     * 初始化配置
     * WebSocketApp constructor.
     * @param $appName
     */
    public function __construct($appName = 'default')
    {
        Config::init($appName, ['host' => env('REDIS_HOST'), 'port' => env('REDIS_PORT'), 'pass' => env('REDIS_PASSWORD'), 'db' => 1], ['ws' => env('WS_SERVER'), 'http' => env('HTTP_SERVER')]);
    }

    public function start()
    {
        try {
            SwooleServer::getInstance()->start();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * 创建web socket链接
     * @param int $clientId
     * @return string
     */
    public function createConnectUrl($clientId)
    {
        return Loader::sign()->createConnectUrl($clientId);
    }

    /**
     * 普通消息推送
     * @param $clientId
     * @param $pushMsgType
     * @param array $data
     * @return mixed
     */
    public function pushMessage($clientId, $pushMsgType, array $data = [])
    {
        return Loader::request()->http($clientId, Loader::config()::SERVICE_MESSAGE, $pushMsgType, $data);
    }

}