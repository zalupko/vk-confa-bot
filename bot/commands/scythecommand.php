<?php
namespace Bot\Commands;

use Bot\User;
use Bot\DB;
use Bot\Tools\Formater;

class ScytheCommand extends Command
{
    const WIN = 'SCYTHE_WIN';
    const LOSS = 'SCYTHE_LOSS';
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        $connection = DB::getInstance()->getConnection();
        $sender = User::getUserInfo($this->data['sender_id']);
        $user = User::getUserInfo($this->data['user_id']);
        $replacements = array(
            'attacker' => '[id'.$sender['VK_USER_ID'].'|'.$sender['VK_USER_NAME'].']',
            'defender' => '[id'.$user['VK_USER_ID'].'|'.$user['VK_USER_NAME'].']',
        );
        $query = 'SELECT PHRASE_CONTEXT FROM vcb_phrases WHERE PHRASE_TYPE = "%s"';
        if (time() % 2 == 0) {
            // SCYTHE_WON
            $query = sprintf($query, self::WIN);
        } else {
            // SCYTHE_LOST
            $query = sprintf($query, self::LOSS);
        }
        $phrase = $connection->query($query)->fetch_assoc();
        $phraseContext = $phrase['PHRASE_CONTEXT'];
        $result = Formater::replacePlaceholders($phraseContext, $replacements);
        return $result;
    }
}