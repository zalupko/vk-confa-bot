<?php
namespace Bot\Commands;

class TestCommand extends Command
{
    protected $data;

    public function execute()
    {
        return 'хуест';
    }

    public function checkCooldown($last, $current)
    {
        // check is not required in this case
        return true;
    }
}
