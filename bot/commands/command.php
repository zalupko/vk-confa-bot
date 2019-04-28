<?php
namespace Bot\Commands;

abstract class Command
{
    protected $data;

    /**
     * @return bool|string false in case of error; response message otherwise;
     */
    abstract public function execute();

    /**
     * @param string $last last message timestamp from database
     * @param string $current current message timestamp
     * @return bool true - can use command; false - cannot use command;
     */
    abstract public function checkCooldown($last, $current);
}