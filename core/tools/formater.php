<?php
namespace Core\Tools;

class Formater
{
    const ENCODING = 'UTF-8';

    public static function tolower($string)
    {
        return \mb_strtolower($string, self::ENCODING);
    }

    public static function toupper($string)
    {
        return \mb_strtoupper($string, self::ENCODING);
    }
}
