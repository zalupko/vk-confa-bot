<?php
namespace Bot\Commands;

class TestCommand extends Base
{
    public function execute()
    {
        $cooldown = $this->checkCooldown($this->date, time());
        $message = 'Huest';
        if ($cooldown) {
            $message = 'Not time yet';
        }
        return $this->getCompiled($message);
    }

    public function checkCooldown($last, $current)
    {
        return 0;
    }
}