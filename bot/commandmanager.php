<?php
namespace Bot;

use Bot\Commands\TestCommand;
use Bot\Commands\UserCommand;
use Bot\Commands\ScytheCommand;

class CommandManager
{
    private $actionPool = array(
        'тест' => TestCommand::class,
        'юзер' => UserCommand::class,
        'коса' => ScytheCommand::class
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
            case (UserCommand::class):
                $object = new UserCommand($this->data);
                break;
            case (ScytheCommand::class):
                $object = new ScytheCommand($this->data);
                break;
            default:
                break;
        }
        return $object->execute();
    }
}
