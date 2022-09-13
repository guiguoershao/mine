<?php


namespace guiguoershao\Rpc;


use guiguoershao\Exception\MiniException;
use Config;

abstract class RpcClient
{
    /**
     * Default host
     *
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * Default port
     *
     * @var int
     */
    protected $port = 18307;

    /**
     * @var string
     */
    protected $version = '2.0';

    /**
     * Setting
     *
     * @var array
     */
    protected $setting = [];


    const RPC_EOL = "\r\n\r\n";

    public function __construct()
    {
        $serviceName = $this->getRpcServiceName();
        $config = Config::get('app.rpc_service_list')[$serviceName] ?? null;

        if (empty($config)) {
            throw new MiniException("not load rpc-service[{$serviceName}] config");
        }
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->setting = $config['setting'];
        $this->version = $config['version'];
    }


    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        } else {
            return $this->request($name, $arguments);
        }
    }

    /**
     * 获取RPC服务名称
     * @return string
     */
    abstract protected function getRpcServiceName(): string;

    /**
     * 获取RPC服务类，对应swoft端接口类 名称
     * @return string
     */
    abstract protected function getRpcServiceClassName(): string;


    /**
     * @param $method
     * @param $param
     * @param string $version
     * @param array $ext
     * @return mixed
     * @throws \Exception
     */
    protected function request($method, $param, $ext = [])
    {
        $fp = stream_socket_client("tcp://{$this->host}:{$this->port}", $errno, $errstr, $this->setting['connect_timeout'] ?? 5);
        if (!$fp) {
            throw new \Exception("stream_socket_client fail errno={$errno} errstr={$errstr}");
        }

        $req = [
            "jsonrpc" => '2.0',
            "method" => sprintf("%s::%s::%s", $this->version, $this->getRpcServiceClassName(), $method),
            'params' => $param,
            'id' => '',
            'ext' => $ext,
        ];
        $data = json_encode($req) . self::RPC_EOL;
        fwrite($fp, $data);

        $result = '';
        while (!feof($fp)) {
            $tmp = stream_socket_recvfrom($fp, 1024);

            if ($pos = strpos($tmp, self::RPC_EOL)) {
                $result .= substr($tmp, 0, $pos);
                break;
            } else {
                $result .= $tmp;
            }
        }

        fclose($fp);
        return json_decode($result, true);
    }
}