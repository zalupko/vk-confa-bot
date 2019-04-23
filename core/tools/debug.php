<?php
namespace Core\Tools;

class Debug
{
    public static function dump($variable)
    {
        ob_start();
        var_dump($variable);
        $html = '<pre>' . ob_get_clean() . '</pre><br/>';
        echo $html;
        return $html;
    }
}
