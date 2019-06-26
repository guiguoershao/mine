<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:30
 */

namespace guiguoershao\Http;


use guiguoershao\Http\Interfaces\ISet;

class Cookie implements ISet
{
    private $cookie = [];
    public function __construct(array $cookie = [])
    {
        $this->cookie = empty($cookie) ? $_COOKIE : $cookie;
    }

    /**
     * 判断键是否存在
     * @param string $key
     * @return bool
     */
    public function isExists(string $key)
    {
        return isset($this->cookie[$key]) ? true : false;
    }

    /**
     * 获取指定键的值
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return isset($this->cookie[$key]) ? $this->cookie[$key] : null;
    }

    /**
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return $this->cookie;
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
        if (isset($this->cookie[$key])) {
            if ($isOverwrite) {
                $this->cookie[$key] = $val;
            }
        } else {
            $this->cookie[$key] = $val;
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
        if (isset($this->cookie[$key])) {
            $this->cookie[$key] = null;
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
        if (isset($this->cookie[$key])) {
            unset($this->cookie[$key]);
        };
        return $this;
    }
}