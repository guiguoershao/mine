<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午5:21
 */

namespace WebSocket\Service;


use WebSocket\Base\Loader;

class UserService
{
    /**
     * 并不是单例
     * @return UserService
     * @throws \Exception
     */
    public static function getInstance(): self
    {
        return new self();
    }

    /**
     * 绑定 fid 和 client_id
     * @param $fd
     * @param $clientId
     * @return bool
     */
    public function bind($fd, $clientId)
    {
        Loader::redis()->sAdd(
            $this->getUserKey($clientId),
            $fd
        );

        Loader::redis()->set(
            $this->getFdKey($fd),
            $clientId
        );

        return true;
    }

    /**
     * 取消绑定
     * @param $fd
     * @return bool
     */
    public function unbind($fd)
    {
        if ($clientId = Loader::redis()->get($this->getFdKey($fd))) {
            Loader::redis()->sRemove($this->getUserKey($clientId), $fd);
        }

        Loader::redis()->del($this->getFdKey($fd));

        return true;
    }

    /**
     * 取消绑定
     * @param $clientId
     * @param $fd
     */
    public function unbindByClientId($clientId, $fd)
    {
        Loader::redis()->sRemove(
            $this->getUserKey($clientId),
            $this->getFdKey($fd)
        );

        Loader::redis()->del($this->getFdKey($fd));
    }

    /**
     *
     * @param $clientId
     * @return string
     */
    private function getUserKey($clientId)
    {
        return Loader::config()::ONLINE_USER_SET . $clientId;
    }

    /**
     *
     * @param $fd
     * @return string
     */
    private function getFdKey($fd)
    {
        return Loader::config()::ONLINE_FD_STRING . $fd;
    }

    /**
     * 获取该客户端的用户集合
     * @param $clientId
     * @return array
     */
    public function findUserSet($clientId)
    {
        return Loader::redis()->sMembers($this->getUserKey($clientId));
    }

    /**
     * 获取某个客户端在线连接数
     * @param $clientId
     * @param \swoole_websocket_server $server
     * @throws \Exception
     */
    public function getOnlineCount($clientId, \swoole_websocket_server $server)
    {
        $fdList = $this->findUserSet($clientId);

        if (!$fdList || !is_array($fdList)) {
            throw new \Exception('获取在线连接数为空');
        }

        $onlineUserCount = 0;
        foreach ($fdList as $fd) {
            if (!$server->exist($fd)) {
                $this->unbindByClientId($clientId, $fd);
                continue;
            }
            if (!$this->clearInvalidUser($clientId, $fd)) {
                continue;
            }
            $onlineUserCount++;
        }

        if ($onlineUserCount < 1) {
            throw new \Exception('无在线客户端');
        }
    }


    /**
     * 清除过期用户
     * @param $clientId
     * @param $fd
     * @return bool
     */
    public function clearInvalidUser($clientId, $fd)
    {
        $fdKey = $this->getFdKey($fd);
        $verifyClientId = Loader::redis()->get($fdKey);

        if ($verifyClientId != $clientId) {
            $clientIdSetKey = $this->getUserKey($verifyClientId);
            Loader::redis()->sRemove($clientIdSetKey, $fd);
            $verifyClientIdSetKey = $this->getUserKey($verifyClientId);
            if (!Loader::redis()->sIsMember($verifyClientIdSetKey, $fd)) {
                Loader::redis()->del($fdKey);
            }
            return false;
        }
        return true;
    }
}