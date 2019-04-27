<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\OptionEntity;

class Options extends Table
{
    protected $table_name = 'vcb_options';
    protected $entity_name = OptionEntity::class;
    const ID = 'ID';
    const OPTION_NAME = 'OPTION_NAME';
    const OPTION_VALUE = 'OPTION_VALUE';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INTEGER',
                'autoincrement' => true,
                'primary' => true
            ),
            self::OPTION_NAME => array(
                'type' => 'VARCHAR(255)',
            ),
            self::OPTION_VALUE => array(
                'type' => 'VARCHAR(255)'
            )
        );
        return $map;
    }
}