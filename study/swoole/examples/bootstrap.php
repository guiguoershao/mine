<?php
define('BASE_PATH', __DIR__);
require_once dirname(BASE_PATH).'/vendor/autoload.php';

class Log {

    private $logService;

    private static $instance;

    public function __construct()
    {
        $this->logService = new \Monolog\Logger('Swoole Log');
        $this->logService->pushHandler(new \Monolog\Handler\StreamHandler(BASE_PATH.'/logs/file.log', \Monolog\Logger::WARNING));
    }

    public static function getInstance()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }

    public function info($message, array $context = array())
    {
        $this->logService->info($message, $context);
    }
}