<?php
namespace Bot\Internal\Managers;

use Bot\Tools\Config;
use Bot\ORM\DB;
use Bot\ORM\Entities\UserEntity;
use Bot\ORM\Tables\Users;
use Bot\Internal\VkClient;

class UserManager
{
    private static $userPool;
    const MENTION_TEMPLATE = '[id%s|%s]';
    /**
     * @param integer|string $userId
     * @return UserEntity ORM entity by user Id
     */
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
        $users = DB::table(Users::class);
        $preparedInfo = array(
            Users::VK_USER_ID => $userInfo->id,
            Users::VK_USER_NAME => $userInfo->first_name . ' ' . $userInfo->last_name,
            Users::LAST_SCYTHE_COMMAND => 1,
            Users::LAST_BATTLE_COMMAND => 1
        );
        $infoObject = $users->add($preparedInfo);
        $id = $infoObject->get(Users::VK_USER_ID);

        self::$userPool[$id] = $infoObject;
    }

    private static function loadUserInfo($userId)
    {
        $users = DB::table(Users::class);
        $infoObject = $users->fetchSingle(Users::VK_USER_ID, $userId);
        if ($infoObject === false) {
            return false;
        }
        self::$userPool[$infoObject->get(Users::VK_USER_ID)] = $infoObject;
        return true;
    }

    private static function requestUserInfo($userId)
    {
        $params = array(
            'user_id' => $userId
        );
        $client = new VkClient(Config::getOption('VK_API_URL'), VkClient::VK_GET_USER, $params);
        $client->send();
        $response = $client->receive();
        return $response->response[0];
    }

    /**
     * @param UserEntity
     * @return string
     */
    public static function getUserMention($entity)
    {
        $id = $entity->get(Users::VK_USER_ID);
        $name = $entity->get(Users::VK_USER_NAME);
        $response = sprintf(self::MENTION_TEMPLATE, $id, $name);
        return $response;
    }
}
