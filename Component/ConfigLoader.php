<?php
namespace Component;

class ConfigLoader
{
    protected static $config = [];

    public static function initConfig($config)
    {
        self::$config = $config;
    }

    public static function getConfig($key)
    {
        return isset(self::$config[$key])?self::$config[$key]:[];
    }
}


