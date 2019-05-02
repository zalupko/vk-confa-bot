<?php
namespace Bot\Vk;

class Event
{
    const MENTION_PATTERN = '/\[([^\|]+)\|/';
    private $sender;
    private $date;
    private $text;
    private $mention;
    private $peer;

    public function __construct($event)
    {
        $this->text = $event->text;
        $this->date = $event->date;
        $this->sender = $event->from_id;
        $this->peer = $event->peer_id;
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
}