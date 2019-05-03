<?php
namespace Bot\Orm\Table;

class Peers extends BaseTable
{
    const ID = 'id';
    const PEER_ID = 'peer_id';
    const PEER_TIMESTAMP = 'peer_last_message';

    protected $table_name = 'vcb_peers';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INT',
                'primary' => true,
                'autoincrement' => true
            ),
            self::PEER_ID => array(
                'type' => 'INT',
                'null' => false
            ),
            self::PEER_TIMESTAMP => array(
                'type' => 'INT',
                'default' => 1
            )
        );
        return $map;
    }
}