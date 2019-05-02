<?php
namespace Bot\Internal\Tools;

class Autoloader
{
    public static function autoLoad($class)
    {
        $format = str_replace('\\', '/', $class);
        $filename = strtolower($format) . '.php';
        require_once($filename);
    }
}

spl_autoload_register(Autoloader::class.'::autoLoad');