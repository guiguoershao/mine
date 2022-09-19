<?php


namespace App\JsonRpc;

use Hyperf\RpcServer\Annotation\RpcService;

/**
 *
 * Class CalculatorService
 * @package App\JsonRpc
 * 注意，如希望通过服务中心来管理服务，需在注解内增加 publishTo 属性
 * @RpcService(name="CalculatorService", protocol="jsonrpc", server="jsonrpc", publishTo="consul")
 */
class CalculatorService implements CalculatorServiceInterface
{
    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function add(int $a, int $b): int
    {
        return $a + $b + 6;
    }
}