<?php
// +----------------------------------------------------------------------
// | Mine Framework [ The Fast Php Framework ]
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 冯炎 <guiguoershao@163.com>
// +----------------------------------------------------------------------
// | Github: 鬼国二少 <https://github.com/guiguoershao>
// +----------------------------------------------------------------------

namespace guiguoershao\Container;

use guiguoershao\Http\Http;
use guiguoershao\Protocol\IServiceProvider;
use guiguoershao\Route\Route;

/**
 * 全局注册容器
 * Class Container
 * @package guiguoershao\Container
 */
class Container
{
    /**
     * 初始化时间
     * @var
     */
    private $startTime;

    /**
     * 注册树
     * @var array
     */
    private $registerTree = [];

    /**
     * 实例树
     * @var array
     */
    private $instanceTree = [];

    /**
     * Container constructor.
     * @param null $time
     */
    public function __construct($time = null)
    {
        $this->startTime = empty($time) ? microtime(true) : $time;
    }

    /**
     * 注册
     * @param $key
     * @param $closure
     * @return $this
     */
    final public function register($key, $closure)
    {
        if (is_object($closure) && !array_key_exists($key, $this->registerTree)) {
            $this->registerTree[$key] = $closure;
        }
        return $this;
    }

    /**
     * 生成实例
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    final public function make($key, $default = null)
    {
        if (isset($this->instanceTree[$key])) {
            return $this->instanceTree[$key];
        }

        if (array_key_exists($key, $this->registerTree)) {
            $closure = $this->registerTree[$key];
            $this->instanceTree[$key] = $closure();
            return $this->instanceTree[$key];
        }

        return $default;
    }


    /**
     * 解析注册服务提供者
     * @param $providers
     * @return $this
     */
    final public function resolverProviders($providers)
    {
        if (empty($providers)) {
            return $this;
        }

        foreach ($providers as $name => $className) {
            $class = new $className;
            if ($class instanceof IServiceProvider) {
                $class->register();
                $class->boot();
            }
        }
        return $this;
    }

    /**
     * 注册门面别名
     * @param array $aliasList
     * @return $this
     */
    final public function aliasClass(array $aliasList)
    {
        foreach ($aliasList as $alias => $fullName) {
            class_alias($fullName, $alias);
        }
        return $this;
    }

    /**
     * @return Http
     */
    public function http(): Http
    {
        return $this->make(Http::class);
    }

    /**
     * 路由
     * @return Route
     */
    public function route(): Route
    {
        return $this->make(Route::class);
    }

    /**
     * @return mixed|null
     */
    public function startTime()
    {
        return $this->startTime;
    }
}