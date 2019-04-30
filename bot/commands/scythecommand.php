<?php
namespace Bot\Commands;

use Bot\ORM\DB;
use Bot\ORM\Tables\Responses;
use Bot\ORM\Tables\Users;
use Bot\Tools\Formater;
use Bot\Internal\Managers\UserManager;

class ScytheCommand extends Command
{
    const WIN = 'SCYTHE_WON';
    const LOSS = 'SCYTHE_LOST';
    const UNDEFINED = 'SCYTHE_UNDEFINED';
    const WRONG = 'SCYTHE_SELF';
    const COOLDOWN = 'SCYTHE_COOLDOWN';
    const PERCENTAGE = 50;
    const TIMER = 15;
    protected $data;

    public function execute()
    {
        //region Initial data for execution
        $battle = true;
        $responses = DB::table(Responses::class);
        $response = false;
        $placeholders = array();
        $sender = $this->sender;
        //endregion
        //region Cooldown check
        $cooldown = $this->checkCooldown($sender->get(Users::LAST_SCYTHE_COMMAND), $this->date);
        if ($cooldown > 0) {
            // SCYTHE_COOLDOWN
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::COOLDOWN);
            $placeholders = array(
                'cooldown' => $cooldown
            );
            $battle = false;
        }
        //endregion
        //region Receiver check
        $receiver = $this->mentioned;
        if ($battle && !$receiver) {
            // SCYTHE_UNDEFINED
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::UNDEFINED);
            $battle = false;
        }
        if ($battle && $sender->get(Users::VK_USER_ID) == $receiver->get(Users::VK_USER_ID)) {
            // SCYTHE_SELF
            $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::WRONG);
            $placeholders = array('attacker' => UserManager::getUserMention($sender));
            $battle = false;
        }
        //endregion
        //region Scythe logic
        if ($battle) {
            $roll = mt_rand(1, 100);
            if ($roll < self::PERCENTAGE) {
                // SCYTHE_LOST
                $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::LOSS);
            } else {
                // SCYTHE_WON
                $response = $responses->fetchSingle(Responses::RESPONSE_TYPE, self::WIN);
            }
            $placeholders = array(
                'attacker' => UserManager::getUserMention($sender),
                'defender' => UserManager::getUserMention($receiver)
            );
            $sender->set(Users::LAST_SCYTHE_COMMAND, $this->date)->save();
        }
        //endregion
        $responseText = Formater::replacePlaceholders($response->get(Responses::RESPONSE_CONTEXT), $placeholders);
        $execution = array(
            'message' => $responseText,
            'attachments' => null
        );
        return $execution;
    }

    public function checkCooldown($last, $current)
    {
        $time = $current-$last;
        return self::TIMER - $time;
    }
}