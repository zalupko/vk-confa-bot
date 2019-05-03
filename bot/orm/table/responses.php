<?php
namespace Bot\Orm\Table;

class Responses extends BaseTable
{
    const ID = 'id';
    const TYPE = 'respoonse_type';
    const CONTEXT = 'response_context';

    protected $table_name = 'vcb_responses';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INT',
                'primary' => true,
                'autoincrement' => true
            ),
            self::TYPE => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            ),
            self::CONTEXT => array(
                'type' => 'TEXT'
            )
        );
        return $map;
    }
}