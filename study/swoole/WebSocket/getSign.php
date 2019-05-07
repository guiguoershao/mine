<?php
require_once "bootstrap.php";
echo  (new WebSocket\WebSocketApp($config))->createConnectUrl(10086);