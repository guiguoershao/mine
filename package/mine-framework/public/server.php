<?php
ini_set("display_errors", "On");

error_reporting(E_ALL | E_STRICT);

//  根路径
define('__ROOT__', dirname(__DIR__));
define('__APP__', __ROOT__ . '/app');
require __ROOT__ . '/vendor/autoload.php';
/**
 * 简单的swoole http 服务器实例
 * User: guola
 * Date: 2019/5/10
 * Time: 18:12
 */

use Swoole\Http\Server as http_server;

$setting = [
    'reactor_num' => 1,
    'worker_num' => 2,
    'max_request' => 1000,
    'task_worker_num' => 1,
    'task_tmpdir' => '/tmp',
    'daemonize' => 0,
    'log_file' => __DIR__ . '/swlog.txt',
    'pid_file' => __DIR__ . '/swhttpserver.pid',
];
function startSwHttpServer($setting)
{
    $webserver = new http_server('0.0.0.0', '8081', SWOOLE_PROCESS, SWOOLE_SOCK_TCP);//如果ssl SWOOLE_SOCK_TCP | SWOOLE_SSL
    $webserver->set($setting);

    /**
     * start回调
     */
    $webserver->on('Start', function (http_server $server) {
        echo 'Start...', "\n";
        // 重新设置进程名称
        swoole_set_process_name('swhttp-master');
    });

    /**
     * managerstart回调
     */
    $webserver->on('ManagerStart', function (http_server $server) {
        echo 'manager start...', "\n";
        // 重新设置进程名称
        swoole_set_process_name('swhttp-manager');
    });

    /**
     * managerstop回调
     */
    $webserver->on('ManagerStop', function (http_server $server) {
        echo 'manager stop...', "\n";
    });

    /**
     * 启动worker进程监听回调，设置定时器
     */
    $webserver->on('WorkerStart', function (http_server $server, $worker_id) use ($setting) {
        // 设置worker的进程
        if ($worker_id >= $setting['worker_num']) {
            swoole_set_process_name("sw-http-task" . $worker_id);
        } else {
            swoole_set_process_name("sw-http-worker" . $worker_id);
        }
        // 延迟绑定
        onWorkerStart($server, $worker_id);

    });

    /**
     * worker进程停止回调函数
     */
    $webserver->on('WorkerStop', function (http_server $server, $worker_id) {
        echo 'worker stop...', "\n";
    });

    /**
     * 接受http请求
     */
    $webserver->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
        try {
            if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
                $response->end('');
                return true;
            }
            onRequest($request, $response);
            return true;
        } catch (\Exception $e) {
            echo $e;
        }
    });

    $webserver->on('task', function (http_server $server, $task_id, $from_worker_id, $data) {
        try {
            $task_data = unserialize($data);
            onTask($server, $task_id, $from_worker_id, $task_data);
        } catch (\Exception $e) {
            echo $e;
        }

    });
    $webserver->start();


}

//请求处理即传统web/MVC框架启动处
function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
{
    $app = new \guiguoershao\Application();
    try {
        $app->bootstrap(new \App\HttpBootstrap($request))->run();
    } catch (Exception $exception) {
        $response->end($exception->getMessage());
//    var_dump($exception->getMessage().' '.$exception->getLine());
    }
    $response->end('hello world');
    echo 'onRequest...', "\n";
}

function onWorkerStart(http_server $server, $worker_id)
{
    echo 'onWorkerStart...', "\n";
}

function onTask(http_server $server, $task_id, $from_worker_id, $task_data)
{
    echo 'onTask...', "\n";
}

startSwHttpServer($setting);
//在onRequest方法中启动执行MVC框架