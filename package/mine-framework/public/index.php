<?php
ini_set("display_errors", "On");

error_reporting(E_ALL | E_STRICT);

//  根路径
define('__ROOT__', dirname(__DIR__));
define('__APP__', __ROOT__ . '/app');
define('__CONFIG__', __ROOT__ . '/config');
require __ROOT__ . '/vendor/autoload.php';
$app = new \guiguoershao\Application();
try {
    $app->bootstrap(new \App\Bootstrap())->run();
} catch (Exception $exception) {
//    var_dump($exception->getMessage().' '.$exception->getLine());
}