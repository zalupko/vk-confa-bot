<?php
namespace Bot;

use Bot\Tools\VkClient;

class LongPolling
{
    private $error;
    private $server;
    private $ts;
    const ACTION = 'a_check';
    const VK_GROUP_ID = 180945331;

    public function getLongPollingServer()
    {
        $params = array(
            'group_id' => self::VK_GROUP_ID
        );
        $client = new VkClient(VkClient::VK_API_URL, VkClient::VK_GET_LP, $params);
        $client->send();
        $response = $client->receive();
        $this->server = $response->response;
        $this->ts = $this->server->ts;
    }

    public function getEvent()
    {
        $params = array(
            'key' => $this->server->key,
            'act' => self::ACTION,
            'ts' => $this->ts,
            'wait' => 25,
        );
        $client = new VkClient($this->server->server, '', $params, false);
        $client->send();
        $event = $client->receive();
        if (isset($event->failed)) {
            $this->error = $event->failed;
			return null;
        }
        $this->ts = $event->ts;
        $update = $event->updates;
        if (empty($update)) {
            return null;
        }
        return array_pop($update);
    }

    public function checkError()
    {
        if ($this->error === null || $this->error != 3) {
            return false;
        }
        return $this->error;
    }

    public function checkKey()
    {
        if ($this->error == 3){
            return false;
        }
        return true;
    }
}
