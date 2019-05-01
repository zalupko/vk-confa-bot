<?php
namespace Bot\Commands;

use Bot\Internal\Managers\UserManager;
use Bot\Internal\Managers\ResponseManager;
use Bot\Internal\Managers\RatingManager;
use Bot\ORM\Tables\Users;
use Bot\Tools\Formater;

class BattleCommand extends Command
{
    protected $data;
    const PTS_DIFF = 25;
    const MIN_CHANCE = 20;
    const BASE_CHANCE = 50;
    const MAX_CHANCE = 70;
    const TIMER = 0;

    const UNDEFINED = 'BATTLE_UNDEFINED';
    const WRONG = 'BATTLE_SELF';
    const WIN = 'BATTLE_WON';
    const LOSE = 'BATTLE_LOST';
    const COOLDOWN = 'BATTLE_COOLDOWN';
    
    public function execute()
    {
        $battle = true;
        $placeholders = array();
        $response = null;
        
        $attackerLastMsgDate = $this->sender->get(Users::LAST_BATTLE_COMMAND);
        $msgDate = $this->date;
        
        $cooldown = $this->checkCooldown($attackerLastMsgDate, $msgDate);
        if ($cooldown > 0) {
            // BATTLE_COOLDOWN
            $response = ResponseManager::getRandomResponse(self::COOLDOWN);
            $placeholders = array('cooldown' => $cooldown);
            $battle = false;
        }
        
        if ($battle && $this->mentioned == false) {
            // BATTLE_UNDEFINED
            $response = ResponseManager::getRandomResponse(self::UNDEFINED);
            $battle = false;
        }
        
        if ($battle && $this->mentioned->get(Users::ID) == $this->sender->get(Users::ID)) {
            // BATTLE_SELF
            $response = ResponseManager::getRandomResponse(self::WRONG);
            $battle = false;
        }
        if ($battle) {
            $attackerMmr = $this->sender->get(Users::MMR);
            $defenderMmr = $this->mentioned->get(Users::MMR);
            RatingManager::registerRating(
                    $this->sender->get(Users::VK_USER_ID), 
                    $attackerMmr
            );
            RatingManager::registerRating(
                    $this->mentioned->get(Users::VK_USER_ID), 
                    $defenderMmr
            );
            $placeholders = array(
                'attacker' => UserManager::getUserMention($this->sender),
                'defender' => UserManager::getUserMention($this->mentioned)
            );
            $percentage = (int)(($attackerMmr - $defenderMmr) / 100);
            $chance = self::BASE_CHANCE + $percentage;
            if ($percentage < self::MIN_CHANCE) {
                $percentage = self::MIN_CHANCE;
            }
            if ($percentage > self::MAX_CHANCE) {
                $percentage = self::MAX_CHANCE;
            }

            $roll = mt_rand(1, 100);
            if ($roll < $chance) {
                // BATTLE_LOST
                $response = ResponseManager::getRandomResponse(self::LOSE);
                // TODO: rework this
                $attackerMmr -= self::PTS_DIFF;
                $defenderMmr += self::PTS_DIFF;
                $change = -1 * self::PTS_DIFF;
            } else {
                // BATTLE_WON
                $response = ResponseManager::getRandomResponse(self::WIN);
                $attackerMmr += self::PTS_DIFF;
                $defenderMmr -= self::PTS_DIFF;
                $change = self::PTS_DIFF;
            }
            $this->sender
                    ->set(Users::LAST_BATTLE_COMMAND, $this->date)
                    ->set(Users::MMR, $attackerMmr)
                    ->save();
            $this->mentioned->set(Users::MMR, $defenderMmr)->save();

            RatingManager::updateRating(
                    $this->sender->get(Users::VK_USER_ID), 
                    $attackerMmr
            );
            RatingManager::updateRating(
                    $this->mentioned->get(Users::VK_USER_ID), 
                    $defenderMmr
            );
        }
        if ($response === null) {
            $response = 'Wtf?!';
        }
        $responseText = Formater::replacePlaceholders($response, $placeholders);
        $responseText .= "\nРейтинг: ".$change;
        $execution = array(
            'message' => $responseText,
            'attachments' => null
        );
        return $execution;
    }

    public function checkCooldown($last, $current)
    {
        $time = $current - $last;
        return self::TIMER - $time;
    }
}