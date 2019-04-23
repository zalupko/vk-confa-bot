<?php
namespace Core;

use Core\Tools\Formater;

class EventResolver
{
    const COMMAND_PREFIX = 'конфа';
    const PREG_SMILE_PATTERN = '/:(.*):/';
    const PREG_USER_PATTERN = '/\[(.*)\]+/';
    const USER_SEP = '|';

    private $text;
    private $sender_id;
    private $peer_id;

    public function __construct($event)
    {
        $this->text = Formater::tolower($event->object->text);
        $this->sender_id = $event->object->from_id;
        $this->peer_id = $event->object->peer_id;
    }

    public function resolve()
    {
        $command = $this->parseCommand();
        $smiles = $this->parseSmiles();
        $message = null;

        if ($command) {
			$action = $command['action'];
			$data = array(
				'sender_id' => $this->sender_id,
				'user_id' => $command['user']
			);
            $commandObject = new CommandManager($command['action'], $data);
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
		list($userId, $userName) = explode(self::USER_SEP, $user[1]);
        $userId = substr($userId, 2);
		unset($userName);

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
        $connection = DB::getInstance()->getConnection();
        $query = 'SELECT SMILE_PATH FROM vcb_smiles WHERE ';
        foreach ($smiles as &$smile) {
            $smile = 'SMILE_NAME = "' . $smile . '"';
        }
        $query .= implode(' OR ', $smiles);
        $attachments = array();
        $dbSmiles = $connection->query($query);
        while ($smile = $dbSmiles->fetch_assoc()) {
            $attachments[] = $smile['SMILE_PATH'];
        }
        return implode(',', $attachments);
    }
}
