<?php


namespace guiguoershao\Rpc;


use guiguoershao\Exception\MiniException;
use guiguoershao\Sys\Configs\Config;

class RpcClient
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
     * Setting
     *
     * @var array
     */
    protected $setting = [];

    /**
     * 请求class
     * @var null
     */
    protected $class = null;


    const RPC_EOL = "\r\n\r\n";


    public function __call($name, ...$arguments)
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        } else {
            return $this->request($name, $arguments);
        }
    }


    /**
     * @param $method
     * @param $param
     * @param string $version
     * @param array $ext
     * @return mixed
     * @throws \Exception
     */
    protected function request($method, $param, $version = '1.0', $ext = [])
    {
        $fp = stream_socket_client("tcp://{$this->host}:{$this->port}", $errno, $errstr);
        if (!$fp) {
            throw new \Exception("stream_socket_client fail errno={$errno} errstr={$errstr}");
        }

        $req = [
            "jsonrpc" => '2.0',
            "method" => sprintf("%s::%s::%s", $version, $this->class, $method),
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