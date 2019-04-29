<?php
namespace Bot;

use Bot\ORM\DB;
use Bot\Tools\Config;
use Bot\Internal\VkClient;

/**
 * Class Application
 * @throws \Exception;
 * @package Bot
 */
class Application
{
    const INTERFACE_NAME = 'cli';
    const INTERFACE_ERROR = 'Script cannot be executed not from CLI';

    public function __construct()
    {
        DB::getConnection();
    }

    public function run()
    {
        $longPoll = new LongPolling();
        $longPoll->getLongPollingServer();
        while (!$longPoll->checkError()) {
            $event = $longPoll->getEvent();
            // Ключ устарел - повторная генерация.
            if (!$longPoll->checkKey()) {
                $longPoll->getLongPollingServer();
                continue;
            }
            if (empty($event)) {
                continue;
            }
            $resolver = new EventResolver($event);
            $resolve = $resolver->resolve();
            if ($resolve instanceof Message) {
                $this->sendCompiled($resolve);
            }
            $this->postResolveActions();
        }
    }


    private function sendCompiled(Message $resolve)
    {
        $client = new VkClient(Config::getOption('VK_API_URL'), VkClient::VK_SEND_MESSAGE, $resolve->getCompiled());
        $client->send();
    }

    public function checkInterface()
    {
        if (php_sapi_name() != self::INTERFACE_NAME) {
            throw new \RuntimeException(self::INTERFACE_ERROR);
        }
    }

    private function postResolveActions()
    {
        
    }
    
    public function __destruct()
    {
        DB::disconnect();
    }
}
