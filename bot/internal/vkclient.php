<?php
namespace Bot\Internal;

use Bot\Internal\Errors\VkClientException;

class VkClient
{
    //region Data that is required to use VK API methods
    const VK_API_VERSION = '5.90';
    const VK_API_URL = 'https://api.vk.com/method/';
    const VK_ACCESS_TOKEN = 'd378d1136fb1ec1e8ec80b516656adbf536a3512e74a22d9c106f42389cdb8b654ab109fa286a8393f5c4';
    const REQUEST_SEPARATOR = '?';
    //endregion

    //region VK API methods
    const VK_SEND_MESSAGE = 'messages.send';
    const VK_GET_USER = 'users.get';
    const VK_GET_LP = 'groups.getLongPollServer';
    //endregion

    private $method;
    private $params;
    private $url;
    private $response;
    private $auth;

    /**
     * VkClient constructor
     * @param string $url where to send the request via VkClient::send()
     * @param string $method Optional - request method (not needed for LP server)
     * @param array $params Optional - additional parameters for VkClient::send() request
     * @param boolean $auth if auth is required, then this will add API version and ACCESS_TOKEN to the request
     */
    public function __construct($url, $method = '', $params = array(), $auth = true)
    {
        $this->method = $method;
        $this->params = $params;
        $this->url = $url;
        $this->auth = $auth;
    }

    /**
     * Sends request to VkClient::$url using VkClient::$method
     * @return null No return data
     */
    public function send()
    {
        $authParams = array();
        if ($this->auth) {
            $authParams = array(
                'access_token' => self::VK_ACCESS_TOKEN,
                'v' => self::VK_API_VERSION
            );
        }
        $params = array_merge($this->params, $authParams);
        $query = self::REQUEST_SEPARATOR . http_build_query($params);
        $request = $this->url . $this->method . $query;
        $this->response = file_get_contents($request);
    }

    /**
     * Returns the response that was sent via VkClient::send() method.
     * 
     * @return boolean|stdClass
     * @throws VkClientException
     */
    public function receive()
    {
        if (empty($this->response)) {
            return false;
        }
        $response = json_decode($this->response);
        if (isset($response->error)) {
            throw new VkClientException(
                $response->error->error_msg,
                $response->error->error_code,
                $this->method,
                $this->response
            );
        }
        return $response;
    }
}
