<?php


namespace App\Service;


use App\Event\UserRegistered;
use App\Model\User;
use Psr\EventDispatcher\EventDispatcherInterface;
use Hyperf\Di\Annotation\Inject;

class UserService implements UserServiceInterface
{
    /**
     * @var bool
     */
    private $enableCache;


    /**
     * @Inject()
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

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
//            'is_cache' => $this->enableCache,
            'id' => 1,
            'name' => '冯火火',
        ];
    }

    public function register(array $payload) :bool
    {
        // 我们假设存在 User 这个实体
        $user = new User($payload);
//        $result = $user->save();
        // 完成账号注册的逻辑
        // 这里 dispatch(object $event) 会逐个运行监听该事件的监听器
        $this->eventDispatcher->dispatch(new UserRegistered($user));
        return true;
    }
}
