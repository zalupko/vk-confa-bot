<?php
namespace Core\Utils;

use Core\DB;

class Upgrader
{
    const CURRENT_VERSION = 101;
    const VERSION_FILE = 'version.txt';

    public static function doUpgrade()
    {
        $version = intval(file_get_contents(self::VERSION_FILE));
        if ($version < self::CURRENT_VERSION) {
            try {

                DB::createInstance();
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
                foreach($newSmiles as $name => $link) {
                    $query = sprintf($template, $name, $link);
                    $connection->query($query);
                    if ($connection->error) {
                        throw new \Exception($connection->error);
                    }
                }
                self::setVersion(self::CURRENT_VERSION);

            } catch (\Exception $Error) {
                echo 'Failed to upgrade from '.$version.' to '.self::CURRENT_VERSION.PHP_EOL;
                echo 'Exception: '.$Error->getMessage();
            }
        }
    }

    private static function setVersion($version)
    {
        file_put_contents(self::VERSION_FILE, $version);
    }
}
