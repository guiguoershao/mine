<?php


namespace App\JsonRpc;


interface CalculatorServiceInterface
{
    /**
     * 求和
     * @param int $a
     * @param int $b
     * @return int
     */
    public function add(int $a, int $b): int;
}