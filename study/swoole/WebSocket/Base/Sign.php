<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-28
 * Time: 上午11:14
 */

namespace WebSocket\Base;


class Sign
{

    /**
     * 创建socket连接url
     * @param $clientId
     * @return string
     * @throws \Exception
     */
    public function createConnectUrl($clientId)
    {
        $query = $this->createQueryData($clientId, Loader::config()::SERVICE_AUTH);

        return Loader::config()->getServerLinks()['ws'] . '?' . http_build_query($query);
    }

    /**
     * 创建请求客户端请求推送参数
     * @param $clientId
     * @param $serviceName
     * @param string $pushMsgType
     * @param array $data
     * @return array|null
     */
    public function createRequestParams($clientId, $serviceName, $pushMsgType = '', array $data = [])
    {
        return $this->createQueryData($clientId, $serviceName, $pushMsgType, $data);
    }

    /**
     * 创建请求参数
     * @param $clientId     客户端编号
     * @param $serviceName  服务名称
     * @param string $pushMsgType 消息推送类型
     * @param array $data 推送数据
     * @return array|null
     * @throws \Exception
     */
    private function createQueryData($clientId, $serviceName, $pushMsgType = '', array $data = [])
    {
        $appName = Loader::config()->getAppName();

        $query = [
            'app_name' => $appName,
            'client_id' => $clientId,
            'service' => $serviceName,
            'msg_type' => $pushMsgType,
            'once' => Util::getRandString(16, 3, 8),
            'timestamp' => time(),
            'expire_in' => Loader::config()->getSignConfig()['expireIn'],
            'data' => $data
        ];

        $query['sign'] = $this->createSign($query);

        if (!$this->checkParams($query)) {
            return null;
        }

        return $query;
    }

    /**
     * 验证参数
     * @param $query
     * @return bool
     */
    public function checkParams($query)
    {
        if (empty($query['app_name']) ||
            empty($query['client_id']) ||
            empty($query['service']) ||
            !isset($query['msg_type']) ||
            empty($query['once']) ||
            empty($query['timestamp']) ||
            empty($query['expire_in']) ||
            empty($query['sign'])
        ) {
            return false;
        }
        return true;
    }

    /**
     * 创建签名
     * @param array $params
     * @return string
     * @throws \Exception
     */
    private function createSign(array $params = [])
    {

        if (!isset($params['app_name']) || empty($params['app_name'])) {
            throw new \Exception("创建签名缺少必要的应用名称");
        }

        $signSecretKey = Loader::config()->getAppKeyByName($params['app_name']);

        if (empty($signSecretKey)) {
            throw new \Exception("创建签名缺少必要的签名秘钥");
        }

        unset($params['sign']);

        ksort($params);

        return md5(http_build_query($params) . "&secret_key={$signSecretKey}");
    }

    /**
     * 请求时效性检测充许有10s误差
     * @param $timestamp
     * @param $expireIn
     * @return bool
     */
    public function verifyRequestIsExpire($timestamp, $expireIn)
    {
        $time = time();
        if ((abs($time - $timestamp) < 10) && $time - ($expireIn + $timestamp) > -10) {
            return false;
        }
        return true;
    }

    /**
     * 签名验证
     * @param $data
     * @param $sign
     * @return bool
     */
    public function verifySign($data, $sign)
    {
        $verifySign = $this->createSign($data);

        return !empty($verifySign) && ($verifySign === $sign);
    }
}