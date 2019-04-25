<?php
namespace Bot\Tools;

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

    public static function replacePlaceholders($string, $placeholders)
    {
        foreach ($placeholders as $holder => $value) {
            $holder = '#'.$holder.'#';
            $string = str_replace($holder, $value, $string);
        }
        return $string;
    }
}
