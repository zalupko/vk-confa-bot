<?php

namespace Bot\Tools;

use Bot\ORM\DB;
use Bot\ORM\Tables\Options;
use Bot\ORM\Tables\Responses;
use Bot\ORM\Tables\Ratings;

class Upgrader
{
    const VERSION_FILE = 'version.txt';
    private static $versionObject;

    private static function checkVersion($dbVersion)
    {
        $version = Config::getOption('BOT_VERSION');
        if ($dbVersion === null) {
            return true;
        }
        return $version < $dbVersion;
    }

    public static function doUpgrade()
    {
        $options = DB::table(Options::class);
        self::$versionObject = $options->fetchSingle(Options::OPTION_NAME, 'BOT_VERSION');

        $version = self::$versionObject->get(Options::OPTION_VALUE);
        if (self::checkVersion($version)) {
            return true;
        }
        if ($version < 100) {
            // Empty upgrader body because version 1.0.0 is installed within install.php
            $version = 100;
            Logger::log('Upgraded from '.$version.' to 100', Logger::INFO);
            self::setVersion(100);
        }
        if ($version < 101) {
            $responses = DB::table(Responses::class);
            $data = array(
                Responses::RESPONSE_TYPE => 'SCYTHE_COOLDOWN',
                Responses::RESPONSE_CONTEXT => 'Косу можно использовать раз в 15 секунд. Подожди #cooldown# секунд'
            );
            $responses->add($data);
            $version = 101;
            Logger::log('Upgraded from '.$version.' to 101', Logger::INFO);
            self::setVersion(101);
        }
        if ($version < 102) {
            $responses = DB::table(Responses::class);
            $data = array(
                Responses::RESPONSE_TYPE => 'SCYTHE_UNDEFINED',
                Responses::RESPONSE_CONTEXT => 'А куда воюем-то?'
            );
            $responses->add($data);
            Logger::log('Upgraded from '.$version.' to 102', Logger::INFO);
            $version = 102;
            self::setVersion(102);
        }
        if ($version < 103) {
            $responses = DB::table(Responses::class);
            $data = array(
                array(
                    Responses::RESPONSE_TYPE => 'BATTLE_UNDEFINED',
                    Responses::RESPONSE_CONTEXT => 'А кого звать-то?'
                ),
                array(
                    Responses::RESPONSE_TYPE => 'BATTLE_COOLDOWN',
                    Responses::RESPONSE_CONTEXT => 'Эй, ебалай, жди #cooldown# секунд. А то че?'
                )
            );
            foreach ($data as $item) {
                $responses->add($item);
            }
            $version = 103;
            Logger::log('Upgraded from '.$version.' to 103', Logger::INFO);
            self::setVersion(103);
        }
        
        if ($version < 104) {
            $responses = DB::table(Responses::class);
            $data = array(
                array(
                    Responses::RESPONSE_TYPE => 'RATING_LOST',
                    Responses::RESPONSE_CONTEXT => 'БЛЯЯЯ ЛУЗСТРИК! #user# проебавси и теперь он - #new_rank#.'
                ),
                array(
                    Responses::RESPONSE_TYPE => 'RATING_GAINED',
                    Responses::RESPONSE_CONTEXT => 'На плюсмораличах #user# вывозит заветный ранг - #new_rank#.'
                )
            );
            foreach ($data as $item) {
                $responses->add($item);
            }
            $version = 104;
            Logger::log('Upgraded from '.$version.' to 104', Logger::INFO);
            self::setVersion(104);
        }
        
        if ($version < 105) {
            $ratings = DB::table(Ratings::class);
            $data = array(
                '1' => 'freezemage',
                '1000' => 'Да разве может быть хуже?',
                '2000' => '2к-бог',
                '3000' => 'вы - 2к помойки',
                '4000' => 'дендибог', 
                '5000' => 'украинская продота' ,
                '6000' => 'чемпион мира по WoT' ,
                '7000' => 'ребята, а это годень?', 
                '8000' => 'ascended', 
                '9000' => 'миракл'
            );
            
            $dataTemplate = array(Ratings::POINTS_REQUIRED, Ratings::RATING_NAME);
            foreach ($data as $req => $name) {
                $item = array_combine($dataTemplate, array($req, $name));
                $ratings->add($item);
            }
            $version = 105;
            self::setVersion(105);
        }
    }

    private static function setVersion($version)
    {
        self::$versionObject->set(Options::OPTION_VALUE, $version)->save();
    }
}
