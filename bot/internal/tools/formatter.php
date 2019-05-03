<?php
namespace Bot\Internal\Tools;

class Formatter
{
    const ENCODING = 'UTF-8';

    public static function tolower($string)
    {
        return mb_strtolower($string, self::ENCODING);
    }

    public static function toupper($string)
    {
        return mb_strtoupper($string, self::ENCODING);
    }

    public static function replacePlaceholders($string, $placeholders)
    {
        foreach ($placeholders as $key => $value) {
            $key = '#'.$key.'#';
            $string = str_replace($key, $value, $string);
        }
        return $string;
    }
}