<?php
namespace Bot;

use Bot\ORM\DB;
use Bot\Tools\Debug;
use Bot\Tools\VkClient;
use Bot\ORM\Tables\User;

class UserManager
{
    private static $userPool;

    public static function getUserInfo($userId)
    {
        if (!isset(self::$userPool[$userId])) {
            $userInfo = self::loadUserInfo($userId);
            if ($userInfo == false) {
                $userInfo = self::requestUserInfo($userId);
                self::saveUserInfo($userInfo);
            }
        }
        return self::$userPool[$userId];
    }

    private static function saveUserInfo($userInfo)
    {
        $users = DB::table(User::class);
        $preparedInfo = array(
            User::VK_USER_ID => $userInfo->id,
            User::VK_USER_NAME => $userInfo->first_name . ' ' . $userInfo->last_name,
            User::LAST_MESSAGE_TIMESTAMP => (int)(time()),
            User::LAST_SCYTHE_COMMAND => 1,
            User::LAST_BATTLE_COMMAND => 1
        );
        $infoObject = $users->add($preparedInfo);
        $id = $infoObject->get(User::VK_USER_ID);

        self::$userPool[$id] = $infoObject;
    }

    private static function loadUserInfo($userId)
    {
        $users = DB::table(User::class);
        $infoObject = $users->fetchSingle(User::VK_USER_ID, $userId);
        if ($infoObject->get(User::ID) == null) {
            return false;
        }
        self::$userPool[$infoObject->get(User::VK_USER_ID)] = $infoObject;
        return true;
    }

    private static function requestUserInfo($userId)
    {
        $params = array(
            'user_id' => $userId
        );
        $client = new VkClient(VkClient::VK_API_URL, VkClient::VK_GET_USER, $params);
        $client->send();
        $response = $client->receive();
        return $response->response[0];
    }
}
