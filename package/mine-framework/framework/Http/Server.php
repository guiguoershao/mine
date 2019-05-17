<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:30
 */

namespace guiguoershao\Http;


use guiguoershao\Interfaces\ISet;

class Server implements ISet
{

    protected static $server;

    public function __construct()
    {
        $this->_init();
    }

    private function _init()
    {
        self::$server = $_SERVER;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->get('HTTP_HOST');
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->get('REQUEST_METHOD');
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->get('REQUEST_URI');
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->get('HTTP_USER_AGENT');
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->get('REQUEST_TIME');
    }

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->get('QUERY_STRING');
    }

    /**
     * @return mixed
     */
    public function getClientIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $client_ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $client_ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR')) {
            $client_ip = getenv('REMOTE_ADDR');
        } else {
            $client_ip = $this->get('REMOTE_ADDR');
        }
        return $client_ip;
    }

    /**
     * @return null|string
     */
    public function getServerIp()
    {
        if (self::$server) {
            if ($this->isExists('SERVER_ADDR')) {
                $server_ip = $this->get('SERVER_ADDR');
            } else {
                $server_ip = $this->get('LOCAL_ADDR');
            }
        } else {
            $server_ip = getenv('SERVER_ADDR');
        }
        return $server_ip;
    }

    /**
     * 判断键是否存在
     * @param string $key
     * @return mixed
     */
    public function isExists(string $key)
    {
        // TODO: Implement isExists() method.
    }

    /**
     * 获取指定键的值
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        // TODO: Implement get() method.
    }

    /**
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return self::$server;
    }

    /**
     * 设置所有指定键值
     * @param string $key
     * @param $val
     * @param bool $isOverwrite 存在时候是否覆盖
     * @return mixed
     */
    public function set(string $key, $val, bool $isOverwrite)
    {
        // TODO: Implement set() method.
    }

    /**
     * 清除
     * @param string|null $key
     * @return mixed
     */
    public function clear(string $key = null)
    {
        // TODO: Implement clear() method.
    }

    /**
     * 删除
     * @param string|null $key
     * @return mixed
     */
    public function destroy(string $key = null)
    {
        // TODO: Implement destroy() method.
    }
}