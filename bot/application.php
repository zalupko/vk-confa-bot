<?php
namespace Bot;

use Bot\ORM\DB;
use Bot\Tools\Config;
use Bot\Tools\Formater;
use Bot\Internal\VkClient;
use Bot\Internal\Managers\RatingManager;
use Bot\Internal\Managers\ResponseManager;
use Bot\Internal\Managers\UserManager;

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
            $this->postResolveActions($resolver->getPeerId(), $resolver->getSenderId());
        }
    }


    private function sendCompiled(Message $message)
    {
        $client = new VkClient(Config::getOption('VK_API_URL'), VkClient::VK_SEND_MESSAGE, $message->getCompiled());
        $client->send();
    }

    public function checkInterface()
    {
        if (php_sapi_name() != self::INTERFACE_NAME) {
            throw new \RuntimeException(self::INTERFACE_ERROR);
        }
    }

    private function postResolveActions($peerId, $senderId)
    {
        //TODO: implement AFK checks for peers
        //TODO: implement post message rank check
        $check = RatingManager::checkRatingChanges($senderId);
        if ($check !== false) {
            if ($check['direction'] == RatingManager::LOST_RANK) {
                $responseType = 'RATING_LOST';
            } else {
                $responseType = 'RATING_GAINED';
            }
            $response = ResponseManager::getRandomResponse($responseType);
            $senderObject = UserManager::getUserInfo($senderId);
            $placeholders = array(
                'user' => UserManager::getUserMention($senderObject),
                'new_rank' => $check['new_rank']
            );
            $data = array(
                'peer_id' => $peerId,
                'message' => Formater::replacePlaceholders($response, $placeholders),
                'attachments' => null
            );
            $message = Message::buildFromArray($data);
            $this->sendCompiled($message);
        }
    }
    
    public function __destruct()
    {
        DB::disconnect();
    }
}
