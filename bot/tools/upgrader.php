<?php

namespace Bot\Tools;

use Bot\ORM\DB;
use Bot\ORM\Tables\Options;
use Bot\ORM\Tables\Responses;
use Bot\ORM\Tables\Smiles;
use Bot\ORM\Tables\Ratings;

class Upgrader
{
    const VERSION_FILE = 'version.txt';
    private static $versionObject;

    private static function checkVersion($dbVersion)
    {
        $version = Config::getOption('BOT_VERSION');
        var_dump($version, $dbVersion);
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
            self::setVersion(100);
        }
        if ($version < 101) {
            $responses = DB::table(Responses::class);
            $data = array(
                Responses::RESPONSE_TYPE => 'SCYTHE_COOLDOWN',
                Responses::RESPONSE_CONTEXT => 'Косу можно использовать раз в 15 секунд. Подожди #cooldown# секунд'
            );
            $responses->add($data);
            self::setVersion(101);
        }
    }

    private static function setVersion($version)
    {
        self::$versionObject->set(Options::OPTION_VALUE, $version)->save();
    }
}
