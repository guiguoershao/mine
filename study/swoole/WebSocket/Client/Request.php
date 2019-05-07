<?php

namespace WebSocket\Client;

use WebSocket\Base\Loader;

/**
 * 请求
 * Class Request
 * @package websocket
 */
class Request
{
    /**
     * Request constructor.
     * @throws \Exception
     */
    public function __construct()
    {
    }

    /**
     * 创建请求
     * @param $clientId     客户端推送编号
     * @param $serviceName  推送消息服务类型名称
     * @param $pushMsgType  消息类型
     * @param array $data 消息内容
     * @return mixed
     * @throws \Exception
     */
    public function http($clientId, $serviceName, $pushMsgType, array $data)
    {
        $query = Loader::sign()->createRequestParams($clientId, $serviceName, $pushMsgType, $data);

        if (empty($query)) {
            throw new \Exception("请求参数不能为空,请检查");
        }

        return $this->_send(Loader::config()->getServerLinks()['http'], $query);
    }

    /**
     * @param $url
     * @param $query
     * @return mixed
     */
    private function _send($url, $query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);//超时时间
        curl_setopt($ch, CURLOPT_POST, true);
        $query = http_build_query($query);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!empty($err)) {
            return $err;
        }
        return $result;
    }
}