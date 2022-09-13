<?php


namespace App\Rpc\Lib;

/**
 * Class TradeInterface
 *
 * @since 2.0
 */
Interface TradeInterface
{
    /**
     * @param int $id
     * @param $type
     * @param int $count
     * @return array
     */
    public function getList(int $id, $type, int $count = 10): array;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;
}
