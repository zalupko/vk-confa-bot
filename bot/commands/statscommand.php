<?php
namespace Bot\Commands;

use Bot\ORM\Tables\Users;
use Bot\Tools\Formater;
use Bot\Internal\Managers\UserManager;
use Bot\Internal\Managers\RatingManager;

class StatsCommand extends Command
{
    protected $data;

    public function execute()
    {
        if ($this->mentioned !== false) {
            $user = $this->mentioned;
            $mmr = $this->mentioned->get(Users::MMR);
        } else {
            $user = $this->sender;
            $mmr = $this->sender->get(Users::MMR);
        }
        $text = "Статистика для пользователя #user#.\nТекущее количетсво ммр птс: #mmr#\nРанг: #rating#";
        $data = array(
            'mmr' => $mmr,
            'user' => UserManager::getUserMention($user),
            'rating' => RatingManager::getUserRating($mmr)
        );
        $message = Formater::replacePlaceholders($text, $data);
        return array(
            'message' => $message,
            'attachments' => null
        );
    }

    public function checkCooldown($last, $current)
    {
        // No check required
        return true;
    }
}