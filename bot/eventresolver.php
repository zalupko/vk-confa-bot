<?php
namespace Bot;

use Bot\ORM\DB;
use Bot\Orm\Tables\Smiles;
use Bot\ORM\Tables\Users;
use Bot\Tools\Debug;
use Bot\Tools\Formater;

class EventResolver
{
    const COMMAND_PREFIX = 'конфа';
    const PREG_SMILE_PATTERN = '/:(.*):/';
    const PREG_USER_PATTERN = '/.*\[(.*)\|(.*)\]+/';
    const USER_SEP = '|';

    private $text;
    private $sender_id;
    private $peer_id;
    private $date;

    public function __construct($event)
    {
        $this->text = Formater::tolower($event->object->text);
        $this->sender_id = $event->object->from_id;
        $this->peer_id = $event->object->peer_id;
        $this->date = $event->object->date;
    }

    public function resolve()
    {
        $command = $this->parseCommand();
        $smiles = $this->parseSmiles();
        $message = null;

        if ($command) {
			$action = $command['action'];
			$data = array(
			    'date' => $this->date,
				'sender_id' => $this->sender_id,
				'user_id' => $command['user']
			);
            $commandObject = new CommandManager($action, $data);
            $execution = $commandObject->act();
            if ($execution) {
                $message = $execution;
            }
        }

        $attachments = $this->getSmiles($smiles);
        if (!$message && !$attachments) {
            return false;
        }
        $resolved = array(
            'user_id' => $this->sender_id,
            'peer_id' => $this->peer_id,
            'message' => $message,
            'attachment' => $attachments
        );
        $this->updateTimestamp($this->sender_id, $this->date);
        return $resolved;
    }

    private function parseCommand()
    {
        $command = array();
        $messageItems = explode(' ', $this->text);
        if (count($messageItems) == 1) {
            return false;
        }
        $isPrefix = array_shift($messageItems) === self::COMMAND_PREFIX;
        if (!$isPrefix) {
            return false;
        }
        $user = $this->parseUser();
        $command['user'] = $user;
        $command['action'] = implode(' ', $messageItems);
        return $command;
    }

    private function parseUser()
    {
        $user = array();
        preg_match(self::PREG_USER_PATTERN, $this->text, $user);
        if (empty($user)) {
            return false;
        }
		list($fullInfo, $userId, $userName) = $user;
        $userId = substr($userId, 2);
		unset($userName, $fullInfo);

        return $userId;
    }

    private function parseSmiles()
    {
        $messageItems = explode(' ', $this->text);
        $smiles = preg_grep(self::PREG_SMILE_PATTERN, $messageItems);
        return $smiles;
    }

    private function getSmiles($smiles)
    {
        if (empty($smiles)) {
            return false;
        }
        $attachments = array();
        $ormSmiles = DB::table(Smiles::class);
        $smileObjects = $ormSmiles->fetchMany(Smiles::SMILE_NAME, $smiles);
        foreach ($smileObjects as $smileObject) {
            $attachments[] = $smileObject->get(Smiles::SMILE_PATH);
        }
        return implode(',', $attachments);
    }

    private function updateTimestamp($userId, $date)
    {
        $object = UserManager::getUserInfo($userId);
        $object->set(Users::LAST_MESSAGE_TIMESTAMP, $date)->save();
    }
}
