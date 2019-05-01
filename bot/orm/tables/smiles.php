<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\SmileEntity;

class Smiles extends Table
{
    protected $table_name = 'vcb_smiles';
    protected $entity_name = SmileEntity::class;
    const ID = 'id';
    const SMILE_NAME = 'smile_name';
    const SMILE_PATH = 'smile_path';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INTEGER',
                'autoincrement' => true,
                'primary' => true
            ),
            self::SMILE_NAME => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            ),
            self::SMILE_PATH => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            )
        );
        return $map;
    }
}