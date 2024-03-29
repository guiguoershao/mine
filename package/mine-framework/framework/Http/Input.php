<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:30
 */

namespace guiguoershao\Http;


use guiguoershao\Http\Interfaces\ISet;

class Input implements ISet
{
    protected $input = [];
    protected static $instance;
    protected static $offsetRaw;

    /**
     * Input constructor.
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        if (!self::$instance) {
            if (empty($input)) {
                $this->input = array_merge($_POST, $_GET);
            } else {
                $this->input = $input;
            }
            self::$instance = $this;
        }
    }

    /**
     * @param string $decodeType
     * @return $this
     */
    public function withRaw($decodeType = 'json')
    {
        if (!self::$offsetRaw) {
            $raw = file_get_contents('php://input');
            switch ($decodeType) {
                default:
                    $raw = json_decode($raw, true);
                    break;
            }
            if (is_array($raw)) {
                $this->input = array_merge($this->input, $raw);
            }
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
        return isset($this->input[$key]) ? true : false;
    }

    /**
     * 获取指定键的值
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return isset($this->input[$key]) ? $this->input[$key] : null;
    }

    /**
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return $this->input;
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
        if (isset($this->input[$key])) {
            if ($isOverwrite) {
                $this->input[$key] = $val;
            }
        } else {
            $this->input[$key] = $val;
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
        if (isset($this->input[$key])) {
            $this->input[$key] = null;
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
        if (isset($this->input[$key])) {
            unset($this->input[$key]);
        };
        return $this;
    }
}