<?php

namespace Bot\Tools;

use Bot\ORM\DB;
use Bot\ORM\Tables\Options;
use Bot\ORM\Tables\Responses;

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
            Logger::log('Upgraded from '.$version.' to 103', Logger::INFO);
            self::setVersion(103);
        }
    }

    private static function setVersion($version)
    {
        self::$versionObject->set(Options::OPTION_VALUE, $version)->save();
    }
}
