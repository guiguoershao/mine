<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-20
 * Time: 下午5:02
 */

namespace guiguoershao\Reflect;


class Reflect
{
    /**
     * @param \ReflectionClass $reflectionClass
     * @param $method
     * @param $params
     * @return array
     */
    public function reflectParam(\ReflectionClass $reflectionClass, $method, $params)
    {
        $result = [];
        $isMethod = $reflectionClass->hasMethod($method);
        if (!$isMethod) {
            return $result;
        }

        //  获取方法
        $reflectMethod = $reflectionClass->getMethod($method);

        //  检查方法是否是公共的
        if (!$reflectMethod->isPublic()) {
            return $result;
        }
        //  获取方法的入参
        $reflectParam = $reflectMethod->getParameters();
        if (empty($reflectParam)) {
            return $result;
        }

        foreach ($reflectParam as $item => $value) {
            $paramName = $value->getName();
            if (isset($params[$paramName])) {
                $result[$paramName] = $params[$params];
                continue;
            }

            $classType = $value->getClass();
            if ($classType) {
                $paramKeyType = $classType->getName();
                if (class_exists($paramKeyType)) {
                    $result[$paramName] = new $paramKeyType;
                }
                continue;
            }
            if ($value->isDefaultValueAvailable()) {
                $result[$paramName] = $value->getDefaultValue();
                continue;
            }
            $result[$paramName] = null;
        }
        return $result;
    }
}