<?php
namespace Core;

use Core\Tools\VkClient;

class User
{
    private static $userPool;

    public static function getUserInfo($userId)
    {
        if (!isset(self::$userPool[$userId])) {
            $userInfo = self::loadUserInfo($userId);
            if (!$userInfo) {
                $userInfo = self::requestUserInfo($userId);
                self::saveUserInfo($userInfo);
            }
        }
        return self::$userPool[$userId];
    }

    private static function saveUserInfo($userInfo)
    {
        $response = $userInfo->response[0];
        $preparedInfo = array(
            'VK_USER_ID' => $response->id,
            'VK_USER_NAME' => $response->first_name . ' ' . $response->last_name,
            'USER_MMR' => 2000,
            'USER_LAST_MESSAGE' => (int)time()
        );
        $columns = implode(', ', array_keys($preparedInfo));
        $values = array_values($preparedInfo);
        foreach ($values as &$value) {
            $value = "'".$value."'";
        }
        $values = implode(', ', $values);
        $query = sprintf(
            'INSERT INTO vcb_users (%s) VALUES (%s);', $columns, $values
        );
        $connection = DB::getInstance()->getConnection();
        $connection->query($query);
        $id = array_shift($preparedInfo);
        self::$userPool[$id] = $preparedInfo;
    }

    private static function loadUserInfo($userId)
    {
        $connection = DB::getInstance()->getConnection();
        $query = sprintf('SELECT * FROM vcb_users WHERE VK_USER_ID = "%s";', $userId);
        $userInfo = $connection->query($query)->fetch_assoc();
        if ($userInfo) {
            Debug::dump($userInfo);
            $id = $userInfo['VK_USER_ID'];
            self::$userPool[$id] = $userInfo;
        }
        return $userInfo;
    }

    private static function requestUserInfo($userId)
    {
        $params = array(
            'user_id' => $userId
        );
        $client = new VkClient(VkClient::VK_API_URL, VkClient::VK_GET_USER, $params);
        $client->send();
        return $client->receive();
    }
}
