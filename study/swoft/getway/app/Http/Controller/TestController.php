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
     * @return array
     */
    public function getList(): array
    {
        $result  = $this->tradeService->getList(12, 'type');

        return $result;
    }
}
