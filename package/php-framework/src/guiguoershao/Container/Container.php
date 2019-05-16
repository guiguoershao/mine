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

namespace Guiguoershao\Container;

class Container
{
    /**
     * @var
     */
    protected $binds;

    /**
     * @var
     */
    protected $instances;

    /**
     * 绑定
     * @param $abstract
     * @param $concrete
     */
    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof \Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    /**
     *
     * @param $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        return call_user_func_array($this->binds[$abstract], $parameters);
    }


}