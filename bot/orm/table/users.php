<?php
namespace Bot\Orm\Table;

use Bot\Orm\DB;
use Bot\Orm\Error\SqlQueryException;

class Users extends BaseTable
{
    const VK_ID = 'vk_user_id';
    const VK_NAME = 'vk_user_name';
    const LAST_BATTLE = 'last_battle_timestamp';
    const LAST_SCYTHE = 'last_scythe_timestamp';
    const CURRENT_RATING = 'rating_id';
    const MMR_PTS = 'mmr_points';

    protected $table_name = 'vcb_users';

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INT',
                'primary' => true,
                'autoincrement' => true
            ),
            self::VK_ID => array(
                'type' => 'INT',
                'unique' => true,
                'null' => false
            ),
            self::VK_NAME => array(
                'type' => 'VARCHAR(255)',
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

    public function add($data)
    {
        $template = 'INSERT IGNORE INTO %s (%s) VALUES (%s);';
        $columns = array();
        $values = array();
        foreach ($data as $column => $value) {
            $columns[] = $column;
            $values[] = "'".$value."'";
        }
        $columns = implode(', ', $columns);
        $values = implode(', ', $values);
        $query = sprintf($template, $this->table_name, $columns, $values);
        $result = DB::query($query);
        if ($result instanceof SqlQueryException) {
            throw $result;
        }
        $lastId = $this->getLastId();
        return $lastId;
    }
}