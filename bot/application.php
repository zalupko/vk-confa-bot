<?php
namespace Bot;

use Bot\ORM\DB;
use Bot\Tools\Config;
use Bot\Tools\Formater;
use Bot\ORM\Tables\Peers;
use Bot\Internal\VkClient;
use Bot\Internal\Managers\RatingManager;
use Bot\Internal\Managers\ResponseManager;
use Bot\Internal\Managers\UserManager;
use Bot\Internal\Managers\PeerManager;


/**
 * Class Application
 * @throws \Exception;
 * @package Bot
 */
class Application
{
    const INTERFACE_NAME = 'cli';
    const INTERFACE_ERROR = 'Script cannot be executed not from CLI';
    const AFK_COOLDOWN = 3600;
    
    public function __construct()
    {
        DB::getConnection();
    }

    public function run()
    {
        echo memory_get_usage().PHP_EOL;
        $longPoll = new LongPolling();
        $longPoll->getLongPollingServer();
        while (!$longPoll->checkError()) {
            echo 'Before iteration: '.memory_get_usage().PHP_EOL;
            $this->preResolveActions();
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
            echo 'After iteration: '.memory_get_usage().PHP_EOL;
        }
    }


    private function sendCompiled(Message $message)
    {
        $client = new VkClient(Config::getOption('VK_API_URL'), VkClient::VK_SEND_MESSAGE, $message->getCompiled());
        $client->send();
        $timestamp = time();
        $table = DB::table(Peers::class);
        $peer = $table->fetchSingle(Peers::PEER_ID, $message->getPeerId());
        $peer->set(Peers::PEER_LAST_MESSAGE, $timestamp)->save();
    }

    public function checkInterface()
    {
        if (php_sapi_name() != self::INTERFACE_NAME) {
            throw new \RuntimeException(self::INTERFACE_ERROR);
        }
    }

    private function preResolveActions()
    {
        $table = DB::table(Peers::class);
        $current = time();
        $peers = $table->fetchMany(1, 1);
        $afkPeers = array();
        foreach ($peers as $peer) {
            $peerLastMessage = $peer->get(Peers::PEER_LAST_MESSAGE);
            if (($current - $peerLastMessage) > self::AFK_COOLDOWN) {
                $afkPeers[] = $peer->get(Peers::PEER_ID);
            }
        }
        foreach ($afkPeers as $afkPeer) {
            $response = ResponseManager::getRandomResponse('AFK');
            $message = Message::buildFromArray(array(
                'message' => $response,
                'peer_id' => $afkPeer
            ));
            $this->sendCompiled($message);
        }
    }
    
    private function postResolveActions($peerId, $senderId)
    {
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
