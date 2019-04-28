<?php
namespace Bot\Commands;

class TestCommand extends Command
{
    protected $data;

    public function execute()
    {
        return array(
            'message' => 'хуест',
            'attachments' => array('wall-151501081_58')
        );
    }

    public function checkCooldown($last, $current)
    {
        // check is not required in this case
        return true;
    }
}
