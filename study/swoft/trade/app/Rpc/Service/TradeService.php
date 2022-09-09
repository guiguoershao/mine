<?php


namespace App\Rpc\Service;


use App\Rpc\Lib\TradeInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class TradeService
 * @package App\Rpc\Service
 *
 * @Service(version="2.0")
 */
class TradeService implements TradeInterface
{

    /**
     * @param int $id
     * @param $type
     * @param int $count
     * @return string[]
     */
    public function getList(int $id, $type, int $count = 10): array
    {
        return [
            'code' => 0,
            'data' => [
                'list' => "这里是数据列表",
            ],
            'msg' => 'ok'
        ];
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return true;
    }
}
