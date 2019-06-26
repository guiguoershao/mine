<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:30
 */

namespace guiguoershao\Http;


use guiguoershao\Http\Interfaces\ISet;

class Header implements ISet
{
    /**
     *
     * @var
     */
    protected $header;


    public function __construct(array $header = [])
    {
        $this->_init($header);
    }

    private function _init(array $header = [])
    {
        if (empty($header)) {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[substr($name, 5, strlen($name))] = $value;
                }
            }
            $this->header = $headers;
        } else {
            $this->header = $header;
        }
        return $this;
    }

    /**
     * 判断键是否存在
     * @param string $key
     * @return bool
     */
    public function isExists(string $key)
    {
        return isset($this->header[$key]) ? true : false;
    }

    /**
     * 获取指定键的值
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return isset($this->header[$key]) ? $this->header[$key] : null;
    }

    /**
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return $this->header;
    }

    /**
     * 设置所有指定键值
     * @param string $key
     * @param $val
     * @param bool $isOverwrite 存在时候是否覆盖
     * @return mixed
     */
    public function set(string $key, $val, bool $isOverwrite = true)
    {
        if (isset($this->header[$key])) {
            if ($isOverwrite) {
                $this->header[$key] = $val;
            }
        } else {
            $this->header[$key] = $val;
        }
        return $this;
    }

    /**
     * 清除
     * @param string|null $key
     * @return mixed
     */
    public function clear(string $key = null)
    {
        if (isset($this->header[$key])) {
            $this->header[$key] = null;
        };
        return $this;
    }

    /**
     * 删除
     * @param string|null $key
     * @return mixed
     */
    public function destroy(string $key = null)
    {
        if (isset($this->header[$key])) {
            unset($this->header[$key]);
        };
        return $this;
    }
}