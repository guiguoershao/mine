<?php


namespace App\Rpc\Service;


use App\Rpc\Lib\TradeInterface;

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
            'list' => "这里是数据列表"
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
