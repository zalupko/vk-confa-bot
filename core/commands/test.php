<?php
namespace Core\Commands;

class Test extends Command
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        return 'хуест';
    }
}