<?php
/**
 * 应用
 * @return \guiguoershao\Container\Container
 */
function app()
{
    return \guiguoershao\Application::containerInstance();
}

/**
 *
 * @param $key
 * @return mixed|null
 */
function make($key)
{
    return app()->make($key);
}

/**
 * 遍历目录并导入文件
 * @param $configDir
 * @param string $closure
 * @param bool $flag
 * @param array $ignore
 */
function scan_require_file($configDir, $closure = "", $flag = true, $ignore = [])
{
    if (is_dir($configDir) && $handle = opendir($configDir)) {
        while (false !== ($fileName = readdir($handle))) {
            if ($fileName != "." && $fileName != "..") {
                $fileArr = explode('.php', $fileName);
                if (count($fileArr) == 2 && empty($fileArr[1])) {
                    if ($flag) {
                        if (!empty($ignore) && in_array($fileArr[0], $ignore)) {
                            continue;
                        }
                    } else {
                        if (empty($ignore) || !in_array($fileArr[0], $ignore)) {
                            continue;
                        }
                    }
                    $conf = require $configDir . '/' . $fileName;
                    if ($closure instanceof Closure && (is_array($conf) || is_object($conf))) {
                        call_user_func($closure, [$fileArr[0], $conf]);
                    }
                }
            }
        }
    }

}

/**
 * 获取配置
 * @param null $key
 * @param null $default
 * @return mixed
 */
function config($key = null, $default = null)
{
    return \Config::get($key, $default);
}
