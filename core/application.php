<?php
namespace Core;


class Application
{
    const METHOD = 'messages.send';
    private $counter;

    public function __construct()
    {
        DB::createInstance();
        $this->counter = 0;
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
            if ($resolve) {
                $this->sendCompiled($resolve);
            }
        }
    }


    private function sendCompiled($resolve)
    {
        $params = array(
            'random_id' => mt_rand(),
            'peer_id' => $resolve['peer_id']
        );

        if (!empty($resolve['message'])) {
            $params['message'] = $resolve['message'];
        }
        if (!empty($resolve['attachment'])) {
            $params['attachment'] = $resolve['attachment'];
        }
        $client = new VkClient(VkClient::VK_API_URL, self::METHOD, $params);
        $client->send();

    }
}