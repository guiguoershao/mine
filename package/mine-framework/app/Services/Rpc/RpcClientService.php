<?php


namespace App\Services\Rpc;


use App\Services\Rpc\Lib\TradeInterface;
use guiguoershao\Rpc\RpcClient;

class RpcClientService
{
    protected static $rpcServices = [];
    public static function trade() : TradeInterface
    {
        if (!isset(self::$rpcServices[__METHOD__])) {
            self::$rpcServices[__METHOD__] = (new class extends RpcClient implements TradeInterface {

                public function getList(int $id, $type, int $count = 10): array
                {
                    return $this->request(__FUNCTION__, func_get_args());
                }

                public function delete(int $id): bool
                {
                    return $this->request(__FUNCTION__, func_get_args());
                }

                /**
                 * @return string
                 */
                protected function getRpcServiceName(): string
                {
                    return 'trade';
                }

                protected function getRpcServiceClassName(): string
                {
                    return "App\Rpc\Lib\TradeInterface";
                }
            });
        }
        return self::$rpcServices[__METHOD__];
    }
}