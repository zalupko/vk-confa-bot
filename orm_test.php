<?php
use Bot\ORM\DB;
use Bot\ORM\Tables\User;
require_once('bot/tools/autoloader.php');
$users = DB::table(User::class);

$user = $users->fetchSingle(User::ID, 1);
echo $user->get(User::VK_USER_NAME) . PHP_EOL;
$user->set(User::VK_USER_NAME, 'Veronika Merchalova')->save();
echo $user->get(User::VK_USER_NAME) . PHP_EOL;

$anotherUser = $users->fetchSingle(User::ID, 2);
var_dump($anotherUser);