<?php
namespace Bot\Commands;

class TestCommand extends Base
{
    private $sender;
    private $mention;
    private $date;

    public function __construct($eventData)
    {
        $this->sender= $eventData['sender'];
        $this->mention = $eventData['mention'];
        $this->date = $eventData['date'];
    }

    public function execute()
    {
        $cooldown = $this->checkCooldown($this->date, time());
        if (!$cooldown) {
            return 'Not time yet';
        }
        return 'huest';
    }

    public function checkCooldown($last, $current)
    {
        return 0;
    }
}