<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Exception\ApiException;
use App\Log;
use App\Service\SystemService;
use App\Service\UserServiceInterface;
use Hyperf\Context\Context;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Request;
use Hyperf\HttpServer\Response;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\Collection;
use Hyperf\Utils\Coroutine;
use Hyperf\Utils\Exception\ParallelExecutionException;
use Hyperf\Utils\Parallel;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\Paginator\Paginator;


/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{

    /**
     * @Inject()
     * @var UserServiceInterface
     */
    protected $userService;
    /**
     * @Inject()
     * @var SystemService
     */
    protected $systemService;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param ConfigInterface $config
     * @return array
     */
    public function index(ConfigInterface $config, RequestInterface $request, ResponseInterface $response, LoggerFactory $loggerFactory)
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        // 第一个参数对应日志的 name, 第二个参数对应 config/autoload/logger.php 内的 key
//        $this->logger = $loggerFactory->get('log', 'default');

        // 测试异常捕捉
//        $a = [];
//        var_dump($a[1]);
//        throw new ApiException("请求错误", -1);

        // 协成测试
//        return $this->co_test();
        //  测试缓存
//        return $this->cache();

//        $this->systemService->flushCache(1);
        $payload = $this->userService->getInfoById(1);
        $this->userService->register($payload);

        Log::get('app')->error("这里是测试日志-222", $payload);

        // 这里根据 $currentPage 和 $perPage 进行数据查询，以下使用 Collection 代替
        $collection = new Collection([
            ['id' => 1, 'name' => 'Tom'],
            ['id' => 2, 'name' => 'Sam'],
            ['id' => 3, 'name' => 'Tim'],
            ['id' => 4, 'name' => 'Joe'],
        ]);
        $currentPage = 2;
        $perPage = 2;
        $users = array_values($collection->forPage($currentPage, $perPage)->toArray());

        var_dump($users);
        return $users;
//        $data = new Paginator($users, $perPage, $currentPage);
//        return $data;
        /*return [
            Coroutine::inCoroutine(), // 判断是否在协成状态
            Coroutine::id(), // 当前协成id
            'method' => $method,
            'message' => "Hello {$user}.",
        ];*/
        $cookie = new Cookie('key', 'value');

        /*for ($i = 0; $i < 10; $i++) {
            $response->write((string)$i);
        }*/

//        return $response->write('Hello Hyperf');

//        return $response->download('/data/app/mine/study/hyperf/my-hyperf-app/public/upload/1.jpg', '1.jpg');

//        return $response->withCookie($cookie)->withContent('Hello Hyperf.');

    }

    public function upload(RequestInterface $request, ResponseInterface $response)
    {
        $file = $request->file('photo');
        // 该路径为上传文件的临时路径
        $path = $file->getPath();
        // 由于 Swoole 上传文件的 tmp_name 并没有保持文件原名，所以这个方法已重写为获取原文件名的后缀名
        $extension = $file->getExtension();
        $file->moveTo('/data/app/mine/study/hyperf/my-hyperf-app/public/upload/1.jpg');

        return $response->xml([
            'code' => 0,
            'msg' => 'ok',
            'data' => null,
        ]);
    }

    protected function cache()
    {

    }

    protected function co_test()
    {
        /*$channel = new \Swoole\Coroutine\Channel();
                co(function () use ($channel) {
                    $channel->push('data');
                });


                co(function () use ($channel) {
                    $data = $channel->pop();
                    var_dump($data);
                });*/
        /*
        // WaitGroup 的用途是使得主协程一直阻塞等待直到所有相关的子协程都已经完成了任务后再继续运行，这里说到的阻塞等待是仅对于主协程（即当前协程）来说的，并不会阻塞当前进程。
        var_dump(time());
        $wg = new \Hyperf\Utils\WaitGroup();
        // 计数器加二
        $wg->add(2);
        // 创建协程 A
        co(function () use ($wg) {
            // some code
            // 计数器减一
            $wg->done();
        });
        // 创建协程 B
        co(function () use ($wg) {
            sleep(1);
            // some code
            // 计数器减一
            $wg->done();
        });
        // 等待协程 A 和协程 B 运行完成
        $wg->wait();
        var_dump(time());*/

        /*//  Parallel 特性是 Hyperf 基于 WaitGroup 特性抽象出来的一个更便捷的使用方法
        $parallel = new Parallel();
        $parallel->add(function () {
            sleep(1);
            return Coroutine::id();
        });
        $parallel->add(function () {
            sleep(2);
            return Coroutine::id();
        });

        try{
            // $results 结果为 [1, 2]
            $results = $parallel->wait();
            var_dump($results);
        } catch(ParallelExecutionException $e){
            var_dump($e->getResults());
            // $e->getResults() 获取协程中的返回值。
            // $e->getThrowables() 获取协程中出现的异常。
        }*/


        /*//  Parallel 限制协成数量，超过数量需要等待
        $parallel = new Parallel(5);
        for ($i = 0; $i < 20; $i++) {
            $parallel->add(function () {
                sleep(1);
                return Coroutine::id();
            });
        }

        try {
            $results = $parallel->wait();
            var_dump($results);
        } catch (ParallelExecutionException $e) {
            // $e->getResults() 获取协程中的返回值。
            // $e->getThrowables() 获取协程中出现的异常。
        }*/

        /*// 将 bar 字符串以 foo 为 key 储存到当前协程上下文中
        $foo = Context::set('foo', 'bar');
        // set 方法会再将 value 作为方法的返回值返回回来，所以 $foo 的值为 bar
        var_dump(Context::get('foo'));

        // 从协程上下文取出 $request 对象并设置 key 为 foo 的 Header，然后再保存到协程上下文中
        $request = Context::override(ServerRequestInterface::class, function (ServerRequestInterface $request) {
            return $request->withAddedHeader('foo', 'bar');
        });

        Context::override('foo', function ($value) {
            var_dump($value);
            $res = "这里是测试{$value}";
            var_dump($res);
        });*/
    }
}
