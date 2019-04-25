<?php

namespace Bot\Tools;

use Bot\DB;

class Upgrader
{
    const VERSION_FILE = 'version.txt';

    public static function doUpgrade()
    {
        $version = intval(file_get_contents(self::VERSION_FILE));
        if ($version < 101) {
            $connection = DB::getInstance()->getConnection();
            $template = 'INSERT INTO vcb_smiles (SMILE_NAME, SMILE_PATH) VALUES ("%s", "%s");';
            $newSmiles = array(
                ':jukwow:' => 'photo-180945331_456239060',
                ':mafacemasol:' => 'photo-180945331_456239061',
                ':goblinnoice:' => 'photo-180945331_456239062',
                ':communisticsreaming:' => 'photo-180945331_456239063',
                ':horrorgadza:' => 'photo-180945331_456239064',
                ':ohmy:' => 'photo-180945331_456239065',
                ':gooslya:' => 'photo-180945331_456239066',
                ':hereicome:' => 'photo-180945331_456239067',
                ':soundofyoura:' => 'photo-180945331_456239068',
                ':goblinha:' => 'photo-180945331_456239070',
                ':goblintea:' => 'photo-180945331_456239071',
                ':necrorofl:' => 'photo-180945331_456239072',
                ':vashezdorovie:' => 'photo-180945331_456239073',
                ':pgg:' => 'photo-180945331_456239074',
                ':old:' => 'photo-180945331_456239075',
                ':чай:' => 'photo-180945331_456239078'
            );
            foreach ($newSmiles as $name => $link) {
                $query = sprintf($template, $name, $link);
                $connection->query($query);
                if ($connection->error) {
                    throw new \Exception($connection->error);
                }
            }
            self::setVersion($version, 101);
        }

        if ($version < 102) {
            $connection = DB::getInstance()->getConnection();
            $table = 'CREATE TABLE IF NOT EXISTS vcb_phrases 
                (
                    ID INTEGER AUTO_INCREMENT PRIMARY KEY,
                    PHRASE_TYPE VARCHAR(255) NOT NULL,
                    PHRASE_CONTEXT TEXT
                );';
            $connection->query($table);
            Debug::dump($connection->error);
            $template = 'INSERT INTO vcb_phrases (PHRASE_TYPE, PHRASE_CONTEXT) VALUES ("%s", "%s");';
            $phrases = array(
                'SCYTHE_WIN' => 'коса #attacker# залетела ЧЕТКО В ЖБАН #defender#',
                'SCYTHE_LOSS' => 'коса #attacker# залетела ЧЕТКО В ЛОТУС #defender#'
            );
            foreach ($phrases as $phraseType => $phraseContext) {
                $query = sprintf($template, $phraseType, $phraseContext);
                if ($connection->query($query) === false) {
                    Debug::dump($connection->error);
                    throw new \Exception('Failed to update DB from '.$version);
                }
            }
            self::setVersion($version, 102);
        }
    }

    private static function setVersion(&$oldVersion, $newVersion)
    {
        $oldVersion = $newVersion;
        file_put_contents(self::VERSION_FILE, $oldVersion);
    }
}
