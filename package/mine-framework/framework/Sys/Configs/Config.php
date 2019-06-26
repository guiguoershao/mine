<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 19-6-19
 * Time: 上午9:49
 */

namespace guiguoershao\Sys\Configs;


class Config
{
    /**
     * 配置文件
     * @var array
     */
    protected $config = [];

    public function __construct()
    {
        $this->init();
    }

    protected function __clone()
    {
        // TODO: Implement __clone() method.
    }

    protected static $instance;

    /**
     * 单例
     * @return mixed
     */
    public static function getInstance() : self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 初始化方法
     */
    protected function init()
    {

    }

    /**
     * 加载配置
     * @param $config
     * @return $this|bool
     */
    public function load($config)
    {
        if (is_array($config)) {
            $this->set($config);
        }

        if (!is_string($config)) {
            return false;
        }

        if (is_dir($config)) {
            $dir = new \DirectoryIterator($config);
            $this->setDirt($dir);
        }

        if (is_file($config)) {
            $fileName = basename($config, ".php");
            $this->set(include $config, '', $fileName);
        }

        return $this;
    }

    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config;
        }

        $keys = explode('.', $key);
        return $this->getConfig($keys, $default);
    }

    private function getConfig(array $keys, $default)
    {
        $len = count($keys);
        $config = $this->config;
        for ($i = 0; $i < $len; $i++) {
            if (!isset($config[$keys[$i]])) {
                return $default;
            }
            if ($i == $len - 1) {
                return $config[$keys[$i]];
            }
            $config = $config[$keys[$i]];
        }
        return $default;
    }

    /**
     * 设置配置值
     * @param $key
     * @param string $value
     * @param string $name
     * @return $this
     */
    public function set($key, $value = '', $name = 'common')
    {

        if (is_array($key)) {
            if (!isset($this->config[$name])) {
                $this->config[$name] = [];
            }
            $this->config[$name] = array_merge($key, $this->config[$name]);
            return $this;
        }

        if (is_string($key) && !empty($value)) {
            $this->config[$name][$key] = $value;
            return $this;
        }
        return $this;
    }

    /**
     * 获取目录下全部配置文件
     * @param \DirectoryIterator $dir
     * @return $this
     */
    public function setDirt(\DirectoryIterator $dir)
    {
        foreach ($dir as $d) {
            if ($d->isDot()) {
                continue;
            }
            if ($d->isFile()) {
                $filename = $d->getPathname();
                $this->load($filename);
            }
        }

        return $this;
    }
}