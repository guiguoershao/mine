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

namespace guiguoershao;

use guiguoershao\Container\Container;
use guiguoershao\Protocol\IBootstrap;

/**
 * 应用程序
 * Class Application
 * @package guiguoershao
 */
class Application
{
    /**
     * 容器单例对象
     * @var
     */
    private static $container;

    /**
     * 启动程序
     * @param IBootstrap $bootstrap
     * @return $this
     */
    public function bootstrap(IBootstrap $bootstrap)
    {
        $bootstrap->boot();
        return $this;
    }

    /**
     * 获取容器实例
     * @return Container
     */
    public static function containerInstance()
    {
        if (!(self::$container instanceof Container)) {
            self::$container = new Container(microtime(true));
        }
        return self::$container;
    }

    public function run()
    {
        static $runFlag = false;

        if (!$runFlag) {
            $runFlag = true;
            try {
                self::containerInstance();
            } catch (\Throwable $exception) {
            }
        }
    }
}