<?php

Class Bootstrap
{
    public static function run($configs, $modules, $globals)
    {

    }

    private static function requireRouteFiles()
    {
        $routeDirectory = self::getGlobalVars('globals')['dirname']
            . self::getGlobalVars('configs')->routeDirectory;
    }

    /**
     * 设置全局变量
     * @param string $keyName
     * @param $maps
     */
    private static function setGlobalVars(string $keyName, $maps)
    {
        $GLOBALS[$keyName] = $maps;
    }

    /**
     * @param string[] ...$keyName
     * @return array|mixed
     */
    private static function getGlobalVars(string ...$keyName)
    {
        $maps = [];

        if (count($keyName) == 1) {
            return $GLOBALS[$keyName[0]];
        }

        array_map(function ($key) use(&$maps) {
           $maps[$key] = $GLOBALS[$key];
        }, $keyName);

        return $maps;
    }
}