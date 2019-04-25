<?php
namespace Bot\Commands;

use Bot\User;

class UserCommand extends Command
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        $data = $this->data;
        if (!isset($data['user_id'])) {
            return false;
        }
        $info = User::getUserInfo($data['user_id']);
        return json_encode($info);
    }
}
