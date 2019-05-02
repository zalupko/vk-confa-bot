<?php
namespace Bot\Vk;

use Bot\Internal\Tools\Debug;
use stdClass;
use Bot\Internal\Tools\Config;
use Bot\Internal\Tools\Logger;

class Client
{
    const URL = 'https://api.vk.com/method/';
    const MESSAGE_SEND = 'messages.send';
    const GET_LONG_POLL = 'groups.getLongPollServer';
    const GET_USER = 'users.get';
    const GET_CONVERSATION = 'message.getConversationMembers';
    const SEP = '?';
    private static $auth = array();

    /**
     * @param $url
     * @param null $method
     * @param array $params
     * @param bool $auth
     * @return stdClass decoded json object of response
     */
    public static function send($url, $method = null, $params = array(), $auth = false)
    {
        if ($auth) {
            if (empty(self::$auth)) {
                self::$auth = array(
                    'v' => Config::getOption('API_VERSION'),
                    'access_token' => Config::getOption('ACCESS_TOKEN')
                );
            }
            $params = array_merge($params, self::$auth);
        }
        $params = http_build_query($params);
        $request = $url.$method.self::SEP.$params;
        Logger::log('VkClient: sent request: '.$request, Logger::DEBUG);
        $response = file_get_contents($request);
        Logger::log('VkClient: got response: '.$response, Logger::DEBUG);
        return json_decode($response);
    }
}