<?php

$server = [
    "ID" => "GetWay_001",  // 服务ID
    "Name" => "GetWay", // 服务名称
    "Tags" => [
        "primary", // 标签
    ],
    "Address" => "120.77.156.30", // 服务地址
    "Port" => 8001,
    "Check" => [
        "Http" => "http://120.77.156.30:8001/test/health",
        "Interval" => "5s",
    ]
];
$server = '{
    "ID": "GetWay_001",
    "Name": "GetWay",
    "Tags": [
        "primary"
    ],
    "Address": "120.77.156.30",
    "Port": 8001,
    "Check": {
        "Http": "http://120.77.156.30:8001/test/health",
        "Interval": "5s"
    }
}';

