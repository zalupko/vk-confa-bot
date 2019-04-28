<?php
namespace Bot\Commands;

use Bot\ORM\Tables\User;
use Bot\UserManager;

class TestCommand extends Command
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        $sender = UserManager::getUserInfo($this->data['sender_id']);
        return $sender->get(User::VK_USER_NAME);
    }

    public function checkCooldown($last, $current)
    {
        return true;
    }
}
