<?php
namespace Core\Tools;

class Config
{
    const CONFIG_FILENAME = 'config.ini';
    private static $config;

    public static function getOption($optionName, $default = null)
    {
        if (self::$config === null) {
            self::$config = parse_ini_file(self::CONFIG_FILENAME);
        }
        if (!isset(self::$config[$optionName])) {
            return $default;
        }
        return self::$config[$optionName];
    }
}
