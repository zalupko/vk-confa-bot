<?php
namespace Bot;

use Bot\ORM\DB;
use Bot\Tools\VkClient;

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
        }
    }


    private function sendCompiled(Message $resolve)
    {
        $client = new VkClient(VkClient::VK_API_URL, VkClient::VK_SEND_MESSAGE, $resolve->getCompiled());
        $client->send();
    }

	public function checkInterface()
	{
		if (php_sapi_name() != self::INTERFACE_NAME) {
			throw new \Exception(self::INTERFACE_ERROR);
		}
	}

	public function __destruct()
    {
        DB::disconnect();
    }
}
