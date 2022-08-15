<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Controller;

use App\Model\Logic\ConsulLogic;
use App\Rpc\Lib\TradeInterface;
use App\Rpc\Lib\UserInterface;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Limiter\Annotation\Mapping\RateLimiter;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * Class TestController
 *
 * @since 2.0
 *
 * @Controller(prefix="test")
 */
class TestController
{

    /**
     * @Reference(pool="trade.pool", version="1.0")
     *
     * @var TradeInterface
     */
    private $tradeService;



    /**
     * @Reference(pool="user.pool", version="1.2")
     *
     * @var UserInterface
     */
    private $userService2;

    /**
     * @RequestMapping(route="trade/getList",method={RequestMethod::GET})
     *
     * @RateLimiter(rate=1, max=2, fallback="limiterFallback")
     * @return array
     */
    public function getList(): array
    {
        return [
            'trade' => $this->tradeService->getList(12, 'type'),
            'user' => $this->userService2->getList(12, 'type'),
        ];
    }

    /**
     * 限流后调用该方法进行返回
     * @return string[]
     */
    public function limiterFallback()
    {
        return ['limter' => '服务器开小差了'];
    }

    /**
     * @RequestMapping(route="health",method={RequestMethod::GET})
     *
     * @return array
     */
    public function health()
    {
        return ["code" => 0, "msg" => "心跳正常"];
    }

    /**
     * @RequestMapping(route="consul/services",method={RequestMethod::GET})
     * @param ConsulLogic $consulLogic
     * @return \Swoft\Consul\Response
     */
    public function getConsulServices()
    {
        $consulLogic = new ConsulLogic();
        return $consulLogic->setAgent()->getServiceList();
    }
}
