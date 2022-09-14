<?php

namespace App\Http\Controller\Api;

use Swoft\Context\Context;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\ControllerMiddleware;

/**
 * Class TestController
 * @package App\Http\Controller\Api
 * @Controller("/api/test")
 * @Middleware(ControllerMiddleware::class)
 */
class TestController
{

    /**
     * @var int
     */
    private $prod_id;

    /**
     * @return int
     */
    public function getProdId(): int
    {
        return $this->prod_id;
    }

    /**
     * @param int $prod_id
     */
    public function setProdId(int $prod_id): void
    {
        $this->prod_id = $prod_id;
    }

    /**
     * @RequestMapping(route="t1",method={RequestMethod::GET,RequestMethod::POST})
     */
    public function t1(Request $request, Response $response)
    {
        return $response->withContentType("application/json")->withData($request->get());
    }

    /**
     * @param Request $request
     * @param Response $response
     * @RequestMapping(route="t2/{id}",params={"id"="\d+"},method={RequestMethod::GET,RequestMethod::POST})
     * @return Response
     */
    public function t2(int $id, Request $request, Response $response)
    {
//        jsonFormObject()
        return $response->withData([$id, $request->get(), filterMethod("ProId")]);
    }


}
