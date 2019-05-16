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

class Guiguoershao extends \Guiguoershao\Http\Request
{
    /**
     * @var
     */
    public $container;

    /**
     * 响应内容
     * @var
     */
    protected $responseBody;

    /**
     * Guiguoershao constructor.
     */
    public function __construct()
    {
        $configCollection = include "./Container/config.php";

        $this->container = new Guiguoershao\Container\Container();

        foreach ($configCollection as $name => $class) {
            $this->container->bind($name, function () use ($class) {
                return new $class;
            });
        }

        //  通过路由规则访问指定的对象和方法
        $this->responseBody = $this->container->make('RouteCollection')
            ->link($_SERVER['routes'][$_SERVER['REQUEST_URI']]->action);
    }

    public function send()
    {
        return new \Guiguoershao\Http\Response($this->responseBody);
    }
}