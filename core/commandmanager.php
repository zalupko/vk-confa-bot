<?php
namespace Core;

use Core\Commands\Test;
use Core\Commands\User;
use Core\Utils\Debug;

class CommandManager
{
    private $actionPool = array(
        //'я вот что хотел спросить' => 'FAQ',
        //'смайлы' => 'SmileList',
        'тест' => Test::class,
        'юзер' => User::class,
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
            Debug::dump(array($this->action, $name, $command));
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
            case (Test::class):
                $object = new Test($this->data);
                break;
            case (User::class):
                $object = new User($this->data);
                break;
            default:
                break;
        }
        return $object->execute();
    }
}