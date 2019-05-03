<?php
namespace Bot\Orm\Table;

class Options extends BaseTable
{
    const ID = 'id';
    const NAME = 'option_name';
    const VALUE = 'option_value';

    protected $table_name = 'vcb_options';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'int',
                'primary' => true,
                'autoincrement' => true
            ),
            self::NAME => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            ),
            self::VALUE => array(
                'type' => 'TEXT'
            )
        );
        return $map;
    }
}