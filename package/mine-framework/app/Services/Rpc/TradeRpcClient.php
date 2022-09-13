<?php


namespace App\Rpc\Services;


use App\Rpc\Lib\TradeInterface;
use guiguoershao\Rpc\RpcClient;

class TradeRpcClient extends RpcClient
{
    public static function trade() : TradeInterface
    {
        return (new class extends RpcClient implements TradeInterface {

            public function getList(int $id, $type, int $count = 10): array
            {
                return $this->request(__METHOD__, func_get_args());
            }

            public function delete(int $id): bool
            {
                return $this->request(__METHOD__, func_get_args());
            }
        });
    }
}