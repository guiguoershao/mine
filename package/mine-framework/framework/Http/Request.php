<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:28
 */

namespace guiguoershao\Http;


class Request
{
    private $uri;
    private $header;
    private $cookie;
    private $session;
    private $input;
    private $server;
    private static $instance;

    final public function __construct()
    {
        if (!self::$instance) {
            $this->header = new Header();
            $this->cookie = new Cookie();
            $this->input = new Input();
            $this->server = new Server();
            self::$instance = $this;
        }
    }

    /**
     * @return Request
     */
    public static function instance()
    {
        return self::$instance;
    }

    /**
     * @return Input
     */
    public function input()
    {
        return self::$instance->input;
    }

    /**
     * @return Cookie
     */
    public function cookie()
    {
        return self::$instance->cookie;
    }

    /**
     * @return mixed
     */
    public function session()
    {
        return self::$instance->session;
    }

    /**
     * @return Header
     */
    public function header()
    {
        return self::$instance->header;
    }

    /**
     * @return mixed
     */
    public function uri()
    {
        return self::$instance->uri;
    }

    /**
     * @return Server
     */
    public function server()
    {
        return self::$instance->server;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return json_decode(json_encode(self::$instance), true);
    }
}