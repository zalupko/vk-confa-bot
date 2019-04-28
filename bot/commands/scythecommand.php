<?php
namespace Bot\Commands;

use Bot\ORM\DB;
use Bot\ORM\Tables\Responses;
use Bot\ORM\Tables\User;
use Bot\Tools\Debug;
use Bot\Tools\Formater;
use Bot\UserManager;

class ScytheCommand extends Command
{
    const WIN = 'SCYTHE_WON';
    const LOSS = 'SCYTHE_LOST';
    const PERCENTAGE = 50;
    const COOLDOWN = 15;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        $responses = DB::table(Responses::class);
        $sender = UserManager::getUserInfo($this->data['sender_id']);
        $cooldown = $this->checkCooldown($sender->get(User::LAST_SCYTHE_COMMAND), $this->data['date']);
        if ($cooldown > 0) {
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, 'SCYTHE_COOLDOWN');
            $text = Formater::replacePlaceholders(
                $response->get(Responses::RESPONSE_CONTEXT),
                array('cooldown' => $cooldown)
            );
            return $text;
        }
        $receiver = UserManager::getUserInfo($this->data['user_id']);
        $roll = mt_rand(1, 100);
        if ($roll < self::PERCENTAGE) {
            // SCYTHE_LOST
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::LOSS);
        } else {
            // SCYTHE_WON
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::WIN);
        }
        if ($sender->get(User::VK_USER_ID) == $receiver->get(User::VK_USER_ID)) {
            // SCYTHE_SELF
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, 'SCYTHE_SELF');
        }
        $responseText = $response->get(Responses::RESPONSE_CONTEXT);
        $responseTemplate = '[id%s|%s]';
        $placeholders = array(
            'attacker' => sprintf($responseTemplate, $sender->get(User::VK_USER_ID), $sender->get(User::VK_USER_NAME)),
            'defender' => sprintf($responseTemplate, $receiver->get(User::VK_USER_ID), $receiver->get(User::VK_USER_NAME)),
        );
        $sender->set(User::LAST_SCYTHE_COMMAND, $this->data['date'])->save();
        return Formater::replacePlaceholders($responseText, $placeholders);
    }

    /**
     * @param int $last
     * @param int $current current message timestamp
     * @return bool true - can send; false - cannot;
     */
    public function checkCooldown($last, $current)
    {
        $time = $current-$last;
        return self::COOLDOWN - $time;
    }
}