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


namespace guiguoershao\Protocol;

use guiguoershao\Container\Container;

/**
 * Interface IBootstrap
 * @package guiguoershao\Protocol
 */
interface IBootstrap
{
    public function boot(Container $app);
}