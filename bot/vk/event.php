<?php
namespace Bot\Vk;

use Bot\Internal\Tools\Debug;
use Bot\Internal\Tools\Formatter;

/**
 * Class Event
 * Prepares event for CommandController
 * @package Bot\Vk
 */
class Event
{
    const MENTION_PATTERN = '/\[([^\|]+)\|/';
    const SMILES_PATTERN = '/:([^:\s]*):/';
    private $sender;
    private $date;
    private $text;
    private $mention;
    private $peer;
    private $smiles;

    public function __construct($event)
    {
        $this->text = Formatter::tolower($event->object->text);
        $this->date = $event->object->date;
        $this->sender = $event->object->from_id;
        $this->peer = $event->object->peer_id;
    }

    private function findMention($text)
    {
        $info = array();
        preg_match(self::MENTION_PATTERN, $text, $info);
        if (empty($info)) {
            return false;
        }
        $id = $info[1];
        return $id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getMention()
    {
        if ($this->mention === null) {
            $this->mention = $this->findMention($this->text);
        }
        return $this->mention;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getPeer()
    {
        return $this->peer;
    }

    public function getSmiles()
    {
        if ($this->smiles === null) {
            $this->findSmiles();
        }
        return $this->smiles;
    }

    private function findSmiles()
    {
        $text = $this->getText();
        $split = explode(' ', $text);
        $smiles = preg_grep(self::SMILES_PATTERN, $split);
        $this->smiles = $smiles;
    }
}