<?php
namespace Bot\Commands;

class AfkCommand extends Base
{
    public function execute()
    {
        // TODO: Implement execute() method.
        $cooldown = $this->checkCooldown(0, 1);
    }

    public function checkCooldown($last, $current)
    {
        // TODO: Implement checkCooldown() method.
    }
}