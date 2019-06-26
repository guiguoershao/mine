<?php
require_once "bootstrap.php";

$webSocketApp = new \WebSocket\WebSocketApp($config);

$webSocketApp->start();