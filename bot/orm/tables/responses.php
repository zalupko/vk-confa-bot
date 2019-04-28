<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\ResponseEntity;

class Responses extends Table
{
    protected $table_name = 'vcb_responses';
    protected $entity_name = ResponseEntity::class;

    const ID = 'id';
    const RESPONSE_TYPE = 'response_type';
    const RESPONSE_CONTEXT = 'response_context';

    public function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INTEGER',
                'autoincrement' => true,
                'primary' => true
            ),
            self::RESPONSE_TYPE => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            ),
            self::RESPONSE_CONTEXT => array(
                'type' => 'TEXT'
            )
        );
        return $map;
    }
}