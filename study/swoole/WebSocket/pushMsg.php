<?php
require_once "bootstrap.php";
$webSocketApp = (new WebSocket\WebSocketApp($config));
for ($i = 0; $i <= 10; $i++) {
    $webSocketApp->pushMessage(10086, "default", ['i' => $i]);
    sleep(1);
}
