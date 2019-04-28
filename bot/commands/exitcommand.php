<?php
namespace Bot\Commands;

use Bot\ORM\Tables\Users;

class ExitCommand extends Command
{
    public static $exit;
    public function execute()
    {
        $isSenderAdmin = $this->sender->get(Users::IS_ADMIN) == 1;
        if (!$isSenderAdmin) {
            $message = 'Только админ может проверять температуру';
            self::$exit = false;
        } else {
            $message = 'Пойду чекну темпера';
            self::$exit = true;
        }
        $response = array(
            'message' => $message,
            'attachments' => null
        );
        return $response;
    }

    public function checkCooldown($last, $current)
    {
        // No check required in this case
        return true;
    }
}