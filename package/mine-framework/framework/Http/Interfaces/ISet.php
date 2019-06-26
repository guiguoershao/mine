<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-5-17
 * Time: 下午4:49
 */

namespace guiguoershao\Http\Interfaces;


Interface ISet
{
    /**
     * 判断键是否存在
     * @param string $key
     * @return mixed
     */
    public function isExists(string $key);

    /**
     * 获取指定键的值
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * 获取所有
     * @return mixed
     */
    public function getAll();

    /**
     * 设置所有指定键值
     * @param string $key
     * @param $val
     * @param bool $isOverwrite 存在时候是否覆盖
     * @return mixed
     */
    public function set(string $key, $val, bool $isOverwrite);

    /**
     * 清除
     * @param string|null $key
     * @return mixed
     */
    public function clear(string $key = null);

    /**
     * 删除
     * @param string|null $key
     * @return mixed
     */
    public function destroy(string $key = null);
}