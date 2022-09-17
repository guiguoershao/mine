<?php


namespace App\Service;


interface UserServiceInterface
{
    public function getInfoById(int $id);

    public function register(array $payload): bool;
}