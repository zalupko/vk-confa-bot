<?php
namespace Bot\Commands;

abstract class Base
{
    /**
     * @return string $result returns the string that must be sent to peer
     */
    abstract public function execute();

    /**
     * @param integer|string $last timestamp of the last command execution
     * @param integer|string $current current timestamp
     * @return integer $cooldown - Remaining cooldown before command can be executed again
     */
    abstract public function checkCooldown($last, $current);
}