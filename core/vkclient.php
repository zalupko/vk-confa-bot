<?php
namespace Core;

class VkClient
{
    const VK_API_VERSION = '5.90';
    const VK_API_URL = 'https://api.vk.com/method/';
    const VK_ACCESS_TOKEN = 'd378d1136fb1ec1e8ec80b516656adbf536a3512e74a22d9c106f42389cdb8b654ab109fa286a8393f5c4';
    const REQUEST_SEPARATOR = '?';

    private $method;
    private $params;
    private $url;
    private $response;
    private $default;

    public function __construct($url, $method = '', $params = array(), $default = true)
    {
        $this->method = $method;
        $this->params = $params;
        $this->url = $url;
        $this->default = $default;
    }

    public function send()
    {
        $defaultParams = array();
        if ($this->default) {
            $defaultParams = array(
                'access_token' => self::VK_ACCESS_TOKEN,
                'v' => self::VK_API_VERSION
            );
        }
        $params = array_merge($this->params, $defaultParams);
        $query = self::REQUEST_SEPARATOR . http_build_query($params);
        $request = $this->url . $this->method . $query;
        $this->response = file_get_contents($request);
    }

    public function receive()
    {
        if (empty($this->response)) {
            return false;
        }
        return json_decode($this->response);
    }
}