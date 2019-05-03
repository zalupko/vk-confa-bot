<?php
namespace Bot\Orm\Table;

class Smiles extends BaseTable
{
    const ID = 'id';
    const NAME = 'smile_name';
    const PATH = 'smile_path';

    protected $table_name = 'vcb_smiles';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'int',
                'primary' => true,
                'autoincrement' => true
            ),
            self::NAME => array(
                'type' => 'varchar(255)',
                'null' => false,
            ),
            self::PATH => array(
                'type' => 'varchar(255)',
                'null' => false
            )
        );
        return $map;
    }
}
