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

use App\Rpc\Lib\TradeInterface;
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
     * @RequestMapping(route="trade/getList",method={RequestMethod::GET})
     *
     * @RateLimiter(rate=1, max=2, fallback="limiterFallback")
     * @return array
     */
    public function getList(): array
    {
        $result = $this->tradeService->getList(12, 'type');

        return $result;
    }

    /**
     * 限流后调用该方法进行返回
     * @return string[]
     */
    public function limiterFallback()
    {
        return ['limter' => '服务器开小差了'];
    }
}
