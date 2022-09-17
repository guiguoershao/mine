<?php


namespace App\Exception\Handler;

use App\Exception\ApiException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;


class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof ApiException) {
            // 格式化输出
            $respData = json_encode([
                'code' => $throwable->getCode() == 0 ? : -1,
                'msg' => $throwable->getMessage(),
                'data' => null,
            ], JSON_UNESCAPED_UNICODE);
            // 阻止异常冒泡
            $this->stopPropagation();

            return $response->withStatus(200)->withBody(new SwooleStream($respData));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        if ($throwable instanceof ApiException) {
            return true;
        }
        return false;
    }
}