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
     * @RequestMapping(route="health",method={RequestMethod::GET})
     *
     * @return array
     */
    public function health()
    {
        return ["code" => 0, "msg" => "心跳正常"];
    }
}
