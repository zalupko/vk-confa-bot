<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\PeerEntity;

class Peers extends Table
{
    const ID = 'id';
    const PEER_ID = 'peer_id';
    const PEER_LAST_MESSAGE = 'peer_last_message';
    protected $table_name = 'vcb_peers';
    protected $entity_name = PeerEntity::class;
    
    public function getMap() {
        $map = array(
            self::ID => array(
                'type' => 'INT',
                'autoincrement' => true,
                'primary' => true
            ),
            self::PEER_ID => array(
                'type' => 'INT',
                'default' => 1
            ),
            self::PEER_LAST_MESSAGE => array(
                'type' => 'INT',
                'default' => 1
            )
        );
        return $map;
    }
}