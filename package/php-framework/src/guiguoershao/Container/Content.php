<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-16
 * Time: 下午4:29
 */

namespace Guiguoershao\Container;


class Content
{
    /**
     * @param $serviceParam
     * @return mixed
     */
    public function run($serviceParam)
    {
        $obj = $this->newInstance($serviceParam[0]);

        return call_user_func([$obj, $serviceParam[1]], []);
    }

    /**
     * @param $serviceFile
     * @return object
     */
    private function newInstance($serviceFile)
    {
        $class = new \ReflectionClass($GLOBALS['configs']->serviceNamespace . $serviceFile);

        return $class->newInstance();
    }
}