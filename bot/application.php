<?php
namespace Bot;

use Bot\Internal\Tools\Config;
use Bot\Internal\Tools\Debug;
use Bot\Orm\DB;
use Bot\Vk\Client;
use Bot\Vk\Event;
use Bot\Internal\Controllers\CommandController;

class Application
{
    const INTERFACE_NAME = 'cli';
    const INTERFACE_ERROR = 'Script cannot be run not from command-line interface';

    public function __construct()
    {
        //DB::connect();
    }

    public function run()
    {
        $longPoll = new LongPolling();
        while (true) {
            $this->preResolveActions();
            $update = $longPoll->getEvent();
            if ($update === false) {
                continue;
            }
            if (!empty($update)) {
                Debug::dump($update, 'RECEIVED_EVENT', true);
                $this->checkPeer($update);
                $event = new Event($update);
                $command = CommandController::getCommandObject($event);
                if ($command) {
                    $message = $command->execute();
                    $this->sendMessage($message);
                }
            }
            $this->postResolveActions();
        }
    }

    private function preResolveActions()
    {

    }

    private function postResolveActions()
    {

    }

    public function checkInterface()
    {
        if (php_sapi_name() !== self::INTERFACE_NAME) {
            throw new \Exception(self::INTERFACE_ERROR);
        }
    }

    private function checkPeer($update)
    {

    }

    private function sendMessage($message)
    {
        $message['random_id'] = mt_rand();
        Client::send(Client::URL, Client::MESSAGE_SEND, $message, true);
    }

    public function __destruct()
    {
        //DB::disconnect();
    }
}