<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午4:48
 */

namespace WebSocket\Service;


use WebSocket\Base\Loader;
use WebSocket\Base\Response;
use swoole_websocket_server;

class MessageService
{
    /**
     * 并不是单例
     * @return MessageService
     * @throws \Exception
     */
    public static function getInstance(): MessageService
    {
        return new MessageService();
    }

    public function push($clientId, Response $response, UserService $userService, swoole_websocket_server $server)
    {
        $onlineUserCount = 0;

        $fdList = Loader::user()->findUserSet($clientId);

        if (!$fdList || !is_array($fdList)) {
            throw new \Exception('获取在线连接数为空');
        }

        foreach ($fdList as $fd) {
            if (!$server->exist($fd)) {
                $userService->unbindByClientId($clientId, $fd);
                continue;
            }
            if (!$userService->clearInvalidUser($clientId, $fd)) {
                continue;
            }
            $server->push($fd, $response->toJson());
            $onlineUserCount++;
        }

        if ($onlineUserCount < 1) {
            throw new \Exception('无在线客户端');
        }

        return true;
    }
}