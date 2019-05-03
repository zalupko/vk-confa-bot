<?php
namespace Bot\Commands;

abstract class Base
{
    protected $sender;
    protected $mention;
    protected $date;
    protected $peer;

    public function __construct($eventData)
    {
        $this->peer = $eventData['peer'];
        $this->sender= $eventData['sender'];
        $this->mention = $eventData['mention'];
        $this->date = $eventData['date'];
    }

    /**
     * @return array $result returns the result of getCompiled
     */
    abstract public function execute();

    /**
     * @param integer|string $last timestamp of the last command execution
     * @param integer|string $current current timestamp
     * @return integer $cooldown - Remaining cooldown before command can be executed again
     */
    abstract public function checkCooldown($last, $current);

    /**
     * @param string $message
     * @param string $attachment
     * @return array $data - message prepared for messages.send VK API method
     */
    protected function getCompiled($message, $attachment)
    {
        $data = array(
            'peer_id' => $this->peer,
            'message' => $message,
            'attachment' => $attachment
        );
        return $data;
    }
}