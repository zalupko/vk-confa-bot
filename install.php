<?php
require_once('bot/internal/autoloader.php');
use Bot\Orm\DB;
use Bot\Orm\Table\Users;
use \Bot\Orm\Table\Peers;
use Bot\Orm\Table\Options;
use Bot\Orm\Table\Responses;

use Bot\Internal\Tools\Debug;
use Bot\Internal\Tools\Logger;

try {
    DB::connect();
    if (DB::dbExists()) {
        throw new RuntimeException('Database already exists', 1);
    }
    DB::createDatabase();
    //region Installing tables
    $options = DB::table(Options::class);
    $peers = DB::table(Peers::class);
    $responses = DB::table(Responses::class);
    $users = DB::table(Users::class);

    $options->create();
    $peers->create();
    $responses->create();
    $users->create();
    //endregion
    //region Installing preset data to the corresponding tables

    //endregion
    DB::disconnect();
} catch (Throwable $error) {
    $message = sprintf('msg: %s; code: %s', $error->getMessage(), $error->getCode());
    Debug::dump($message, 'DB_INSTALL_ERROR');
    Logger::log($error->getMessage(), Logger::ERROR);
    Logger::closeFile();
}