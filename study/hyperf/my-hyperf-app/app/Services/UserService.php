<?php


namespace App\Services;


class UserService implements UserServiceInterface
{
    /**
     * @var bool
     */
    private $enableCache;

    public function __construct(bool $enableCache)
    {
        // 接收值并储存于类属性中
        $this->enableCache = $enableCache;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getInfoById(int $id)
    {
        // 我们假设存在一个 Info 实体
        return [
            'is_cache' => $this->enableCache,
            'id' => 1,
            'name' => '冯火火',
        ];
    }
}
