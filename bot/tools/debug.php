<?php
namespace Bot\Tools;

class Debug
{
    public static function dump($variable)
    {
        var_dump($variable);
        echo PHP_EOL;
        return $variable;
    }
}
