<?php
namespace Bot\Internal\Tools;

class Config
{
    const FILENAME = 'config.ini';
    private static $config;

    private static function getConfig()
    {
        if (self::$config === null) {
            self::$config = parse_ini_file(self::FILENAME);
        }
        return self::$config;
    }

    public static function getOption($name, $default = null)
    {
        $config = self::getConfig();
        if (!isset($config[$name])) {
            return $default;
        }
        return $config[$name];
    }
}