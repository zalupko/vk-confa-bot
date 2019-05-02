<?php
namespace Bot;

use Exception;
use Bot\Internal\Tools\Config;
use Bot\Vk\Client;

class LongPolling
{
    private $ts;
    private $server;
    private $key;

    const ACTION = 'a_check';
    const WAIT = 25;

    public function __construct()
    {
        $response = $this->refreshServer();
        $this->server = $response->server;
        $this->key = $response->key;
        $this->ts = $response->ts;
    }

    public function getEvent()
    {
        $params = array(
            'act' => self::ACTION,
            'key' => $this->key,
            'ts' => $this->ts,
            'wait' => self::WAIT
        );
        $event = Client::send($this->server, '', $params);
        if (!$this->resolveError($event)) {
            return false;
        }
        $this->ts = $event->ts;
        $updates = $event->updates;
        return array_shift($updates);
    }

    private function resolveError($event)
    {
        if (!isset($event->failed)) {
            return true;
        }
        switch ($event->failed) {
            case 1:
                $this->ts = $event->ts;
                break;
            case 2:
                $response = $this->refreshServer();
                $this->key = $response->key;
                break;
            case 3:
                $response = $this->refreshServer();
                $this->key = $response->key;
                $this->ts = $response->ts;
                break;
            default:
                throw new Exception('Could not resolve event error');
                break;
        }
        return false;
    }

    private function refreshServer()
    {
        $params = array(
            'group_id' => Config::getOption('GROUP_ID')
        );
        $response = Client::send(Client::URL, Client::GET_LONG_POLL, $params, true);
        return $response->response;
    }
}