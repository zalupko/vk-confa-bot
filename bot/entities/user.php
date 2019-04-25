<?php
namespace Bot\Entities;

class User extends Entity
{
    protected $tableName = 'vcb_users';

    const VK_USER_ID_COLUMN = 'vk_user_id';
    const VK_USER_NAME_COLUMN = 'vk_user_name';
    const MMR_COLUMN = 'mmr';
    const USER_LAST_MESSAGE_COLUMN = 'user_last_message';

    private $id;
    private $vk_user_id;
    private $vk_user_name;
    private $mmr;
    private $user_last_message;

    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function get($columnName)
    {

    }

    public function set($columnName, $value)
    {

    }

    public function sync()
    {
        if (!empty($this->error)) {
            throw new \Exception($this->error['error'], $this->error['code']);
        }
        foreach ($this->raw as $columnName => $columnValue) {
            $this->$columnName = $columnValue;
        }
    }
}