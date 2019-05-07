<?php
/**
 * 相关配置对象
 * User: fengyan
 * Date: 18-9-28
 * Time: 上午10:57
 */

namespace WebSocket\Base;


class Config
{
    /**
     * 在线用户键名称
     */
    const ONLINE_USER_SET = "ws:on:u:set:";

    /**
     * 在线fd编号redis键名称
     */
    const ONLINE_FD_STRING = "ws:on:fid:str:";

    /**
     * 授权服务名称
     */
    const SERVICE_AUTH = 'auth';

    /**
     * 用户服务名称
     */
    const SERVICE_USER = 'user';

    /**
     * 消息服务名称
     */
    const SERVICE_MESSAGE = 'message';

    /**
     * 在线统计
     */
    const USER_ONLINE_COUNT = "user.onlineCount";

    const APP_LIST = [
        'default' => 'GHCkSOgnDxxjpnAw1Ki1WhSX7g9X2auVo4QY3I8F1Cs',
    ];

    /**
     * response 编码
     */
    const RESP_CODE_LIST = [
        'SUCCESS' => 0,  //  成功
        'PARAM_ERROR' => 2000,  //参数级2开头
        'SIGN_ERROR' => 2001,   //签名错误
        'REQUEST_EXPIRE' => 2002,   //请求过期
        'UNKNOW_SERVICE' => 2003,   //未知方法
        'AUTH_FAIL' => 4000,    //权限级4开头
    ];

    /**
     * 当前websocket应用名
     * @var string
     */
    private $appName = 'default';

    /**
     * redis 配置
     * @var array
     */
    private $redisConfig = ['host' => '127.0.0.1', 'port' => '6379', 'pass' => null, 'db' => 0];

    /**
     * server links
     * @var array
     */
    private $serverLinks = ['ws'=>'ws://127.0.0.1:9501', 'http'=>'http://127.0.0.1:9501'];

    /**
     * swoole server info
     * @var array
     */
    private $serverConnectInfo = ['ip'=>'127.0.0.1', 'port'=>'9501'];

    /**
     * 数据签名相关配置项
     * @var array
     */
    private $signConfig = ['expireIn'=>600];

    /**
     * 单例对象
     * @var
     */
    private static $instance;


    private function __construct(string $appName, array $redisConfig = [], array $serverLinks = [], array $serverConnectInfo = [], array $signConfig = [])
    {
        $appName && $this->appName = $appName;
        $redisConfig && $this->redisConfig = $redisConfig;
        $serverLinks && $this->serverLinks = $serverLinks;
        $serverConnectInfo && $this->serverConnectInfo = $serverConnectInfo;
        $signConfig && $this->signConfig = $signConfig;
    }


    /**
     * 初始化配置内容
     * @param string $appName
     * @param array $redisConfig        ['host' => '127.0.0.1', 'port' => '6379', 'pass' => null, 'db' => 0];
     * @param array $serverLinks
     * @param array $serverConnectInfo  ['ip'=>'127.0.0.1', 'post'=>'9501']
     * @param array $signConfig         ['expireIn'=>600];
     */
    public static function init(string $appName, array $redisConfig = [], array $serverLinks = [], array $serverConnectInfo = ['ip'=>'127.0.0.1', 'port'=>'9501'], array $signConfig = ['expireIn'=>600])
    {
        self::$instance = new self($appName, $redisConfig, $serverLinks, $serverConnectInfo, $signConfig);
    }

    /**
     * 获取配置实例
     * @return Config
     * @throws \Exception
     */
    public static function getInstance(): self
    {
        if (!(self::$instance instanceof self)) {
            throw new \Exception("请初始化配置文件");
        }

        return self::$instance;
    }

    /**
     * 获取Redis配置
     * @return array
     */
    public function getRedisConfig(): array
    {
        return $this->redisConfig;
    }

    /**
     * 获取应用对应的秘钥
     * @param $appName
     * @return mixed
     */
    public function getAppKeyByName($appName)
    {
        return isset(self::APP_LIST[$appName]) ? self::APP_LIST[$appName] : null;
    }

    /**
     * 获取应用名
     * @return string
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * 获取服务链接信息
     * @return array
     */
    public function getServerLinks(): array
    {
        return $this->serverLinks;
    }

    /**
     * 获取服务连接信息
     * @return array
     */
    public function getServerConnectInfo(): array
    {
        return $this->serverConnectInfo;
    }

    /**
     * 获取签名配置信息
     * @return array
     */
    public function getSignConfig(): array
    {
        return $this->signConfig;
    }
}