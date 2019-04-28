<?php
namespace Bot;

use Bot\Commands\SmilesListCommand;
use Bot\Commands\TestCommand;
use Bot\Commands\ScytheCommand;

class CommandManager
{
    private $actionPool = array(
        'тест' => TestCommand::class,
        'коса' => ScytheCommand::class,
        'смайлы' => SmilesListCommand::class
    );
    private $action;
    private $data;

    public function __construct($action, $data = null)
    {
        $this->action = $action;
        $this->data = $data;
    }

    private function determineAction()
    {
        $action = false;
        foreach ($this->actionPool as $name => $command) {
            if (strpos($this->action, $name) !== false) {
                $action = $command;
                break;
            }
        }
        return $action;
    }

    public function act()
    {
        $command = $this->determineAction();
        if (!$command) {
            return false;
        }
        $object = null;

        switch ($command) {
            case (TestCommand::class):
                $object = new TestCommand($this->data);
                break;
            case (ScytheCommand::class):
                $object = new ScytheCommand($this->data);
                break;
            case (SmilesListCommand::class):
                $object = new SmilesListCommand($this->data);
                break;
            default:
                break;
        }
        return $object->execute();
    }
}
