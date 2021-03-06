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
     * @param $config ['redis'=>['host' => '', 'port' => '', 'pass' => '', 'db' => 1], 'ws_link'=>['ws' => 'ws://127.0.0.1:9501', 'http' => 'http://127.0.0.1:9501'], 'ws_connect' => ['ip'=>'127.0.0.1', 'port'=>'9501']]
     */
    public function __construct($config, $appName = 'default')
    {
        Config::init($appName, $config['redis'], $config['ws_link'], $config['ws_connect']);
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