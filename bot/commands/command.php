<?php
namespace Bot\Commands;

use Bot\UserManager;

abstract class Command
{
    protected $date;
    protected $sender;
    protected $mentioned;

    public function __construct($data)
    {
        $this->date = !isset($data['date']) ? (int)(time()) : $data['date'];
        $this->sender = false;
        $this->mentioned = false;
        if (isset($data['sender_id'])) {
            $this->sender = UserManager::getUserInfo($data['sender_id']);
        }
        if ($data['user_id'] !== false) {
            $this->mentioned = UserManager::getUserInfo($data['user_id']);
        }
    }

    /**
     * Executes given command by its name in CommandManager::actionPool
     * @return bool|string false in case of error; response message otherwise;
     */
    abstract public function execute();

    /**
     * @param string $last last message timestamp from database
     * @param string $current current message timestamp
     * @return int cooldown time;
     */
    abstract public function checkCooldown($last, $current);
}