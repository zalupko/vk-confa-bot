<?php
namespace Bot\Commands;

class TestCommand extends Base
{
    public function execute()
    {
        $cooldown = $this->checkCooldown($this->date, time());
        $message = 'Huest';
        $attachment = null;
        if ($cooldown) {
            $message = 'Not time yet';
        }
        return $this->getCompiled($message, $attachment);
    }

    public function checkCooldown($last, $current)
    {
        return 0;
    }
}