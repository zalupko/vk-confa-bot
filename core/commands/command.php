<?php
namespace Core\Commands;

abstract class Command
{
    protected $data;
    abstract public function execute();
}
/*class Command
{
    private $commandPool = array(
        'я вот что хотел спросить' => 'faq',
        'смайлы' => 'smileList',
        'тест' => 'test',
        'юзер' => 'user'
    );
    private $command;
    private $user;

    public function __construct($commandInfo)
    {
        $this->command = $commandInfo['action'];

        if (isset($commandInfo['user']) && !empty($commandInfo['user'])) {
            $this->user['id'] = $commandInfo['user'][0];
            $this->user['name'] = $commandInfo['user'][1];
        }

        Debug::dump(json_encode($this->user));
    }

    public function execute()
    {
        $actionName = $this->findCommand();
        return $this->$actionName();
    }

    private function findCommand()
    {
        $execute = false;
        foreach ($this->commandPool as $command => $action) {
            if (strpos($this->command, $command) !== false) {
                $execute = $action;
                break;
            }
        }
        return $execute;
    }

    private function faq()
    {
        return false;
    }

    private function smileList()
    {
        return false;
    }

    private function test()
    {
        return 'хуест';
    }

    private function user()
    {
        $user = User::getUserInfo($this->user['id']);
        Debug::dump($user);
        return json_encode($user);
    }
}*/