<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\UserEntity;
use Bot\ORM\Error;

class User extends Table
{
    protected $table_name = 'vcb_users';
    const ID = 'id';
    const VK_USER_NAME = 'vk_user_name';
    const LAST_MESSAGE_TIMESTAMP = 'last_message_timestamp';
    const VK_USER_ID = 'vk_user_id';

    public function fetchSingle($column, $value)
    {
        $fetch = parent::fetchSingle($column, $value);
        if ($fetch instanceof Error) {
            throw new \Exception($fetch->getError(), $fetch->getCode());
        }
        $data = $fetch->fetch_assoc();
        $object = new UserEntity($this, $data);
        return $object;
    }

    /**
     * @param $column
     * @param $values
     * @return array|null
     * @throws \Exception
     */
    public function fetchMany($column, $values)
    {
        $fetch = parent::fetchMany($column, $values);
        if ($fetch instanceof Error) {
            throw new \Exception($fetch->getError(), $fetch->getCode());
        }
        $objects = array();
        while ($data = $fetch->fetch_assoc()) {
            $objects[] = new UserEntity($this, $data);
        }
        return $objects;
    }
}