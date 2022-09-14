<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

function user_func(): string
{
    return 'hello';
}

/**
 * @return \Swoft\Http\Message\Request|\Swoft\WebSocket\Server\Message\Request
 */
function request()
{
    return \Swoft\Context\Context::get()->getRequest();
}

/**
 * @return \Swoft\Http\Message\Response|\Swoft\WebSocket\Server\Message\Response
 */
function response()
{
    return \Swoft\Context\Context::get()->getResponse();
}

/**
 * @param $class
 * @return bool|object
 */
function jsonFormObject($class)
{
    $req = request();
    try {
        $contentType = $req->getHeader('content-type');
        if (!$contentType || false === stripos($contentType[0], \Swoft\Http\Message\ContentType::JSON)) {
            return false;
        }

        $row = $req->getBody()->getContents();

        $map = json_decode($row, true);

        $classObj = new ReflectionClass($class);
        $methods = $classObj->getMethods(ReflectionMethod::IS_PUBLIC);

        $classInstance = $classObj->newInstance(); // 根据反射创建实例
        foreach ($methods as $method) {
            if (preg_match("/^set(\w+)/", $method->getName(), $matches)) {
                invokeSetterMethod($matches[1], $classObj, $map, $classInstance);
            }
        }

        return $classInstance;
    } catch (Exception $exception) {
        return false;
    }
}

function invokeSetterMethod($name, ReflectionClass $classObj, $jsonMap, &$classInstance)
{
    $filterName = strtolower(filterMethod($name));
    $props = $classObj->getProperties(ReflectionMethod::IS_PRIVATE);

    foreach ($props as $prop) {
        if (strtolower($prop->getName()) == $filterName) {
            $method = $classObj->getMethod("set{$name}");
            $args = $method->getParameters(); // 取参数
            if (count($args) == 1 && isset($jsonMap[$filterName])) {
                $method->invoke($classInstance, $jsonMap[$filterName]);
            }
        }
    }
}

function filterMethod($name) {
    $name = preg_replace("/(?<=[a-z])([A-Z])/", "_$1", $name);

    return $name;
}
