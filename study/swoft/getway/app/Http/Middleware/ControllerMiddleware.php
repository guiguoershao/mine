<?php


namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Contract\MiddlewareInterface;

/**
 * @Bean()
 * Class ControllerMiddleware
 * @package App\Http\Middleware
 */
class ControllerMiddleware implements MiddlewareInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var $ret \Swoft\Http\Message\Response */
        $ret = $handler->handle($request);

        $ret->withContentType(ContentType::JSON);
        $data = $ret->getData();

        $data[] = "这里是测试内容";
        return $ret->withData($data);
    }
}
