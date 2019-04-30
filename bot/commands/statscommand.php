<?php
namespace Bot\Commands;

use Bot\ORM\Tables\Users;
use Bot\Tools\Formater;

class StatsCommand extends Command
{
    protected $data;

    public function execute()
    {
        $mmr = $this->sender->get(Users::MMR);
        $text = 'Текущее количетсво ммр птс: #mmr#';
        $message = Formater::replacePlaceholders($text, array('mmr' => $mmr));
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