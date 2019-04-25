<?php
namespace Bot\Tools;

class Loader
{

    public static function autoloader($class)
    {
        $file = strtolower(str_replace('\\', '/', $class)).'.php';
        require_once($file);
    }
}
$methodName = Loader::class . '::autoloader';
spl_autoload_register($methodName);
