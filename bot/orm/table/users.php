<?php
namespace Bot\Orm\Table;

class Users extends BaseTable
{
    const VK_ID = 'vk_user_id';
    const VK_NAME = 'vk_user_name';
    const LAST_BATTLE = 'last_battle_timestamp';
    const LAST_SCYTHE = 'last_scythe_timestamp';
    const CURRENT_RATING = 'rating_id';
    const MMR_PTS = 'mmr_points';

    protected $table_name = 'vcb_users';

    public function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INT',
                'primary' => true,
                'autoincrement' => true
            ),
            self::VK_ID => array(
                'type' => 'INT',
                'null' => false
            ),
            self::LAST_BATTLE => array(
                'type' => 'INT',
                'default' => 1
            ),
            self::LAST_SCYTHE => array(
                'type' => 'INT',
                'default' => 1
            ),
            self::CURRENT_RATING => array(
                'type' => 'INT',
                'default' => 3
            ),
            self::MMR_PTS => array(
                'type' => 'INT',
                'default' => 2000
            )
        );
        return $map;
    }
}