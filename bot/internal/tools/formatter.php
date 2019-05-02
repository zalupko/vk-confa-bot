<?php
namespace Bot\Internal\Tools;

class Formatter
{
    const ENCONDING = 'UTF-8';

    public static function tolower($string)
    {

    }

    public static function toupper($string)
    {

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