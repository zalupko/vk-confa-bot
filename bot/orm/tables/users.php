<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\UserEntity;

class Users extends Table
{
    protected $table_name = 'vcb_users';
    protected $entity_name = UserEntity::class;
    const ID = 'id';
    const VK_USER_NAME = 'vk_user_name';
    const LAST_MESSAGE_TIMESTAMP = 'last_message_timestamp';
    const LAST_SCYTHE_COMMAND = 'last_scythe_command';
    const LAST_BATTLE_COMMAND = 'last_battle_command';
    const VK_USER_ID = 'vk_user_id';
    const MMR = 'mmr';

    protected function getMap()
    {

        $map = array(
            self::ID => array(
                'type' => 'INTEGER',
                'autoincrement' => true,
                'primary' => true
            ),
            self::VK_USER_ID => array(
                'type' => 'INTEGER',
                'null' => false
            ),
            self::VK_USER_NAME => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            ),
            self::MMR => array(
                'type' => 'INTEGER',
                'default' => 2000
            ),
            self::LAST_MESSAGE_TIMESTAMP => array(
                'type' => 'INTEGER',
                'null' => false
            ),
            self::LAST_BATTLE_COMMAND => array(
                'type' => 'INTEGER',
                'null' => false
            ),
            self::LAST_SCYTHE_COMMAND => array(
                'type' => 'INTEGER',
                'null' => false
            ),
        );
        return $map;
    }
}