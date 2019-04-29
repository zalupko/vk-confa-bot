<?php
ini_set('display_errors', 'On');
use Bot\Application;
use Bot\Tools\Logger;
use Bot\Tools\Upgrader;
require_once('bot/tools/autoloader.php');

$application = new Application();
try {
    Upgrader::doUpgrade();
    $application->checkInterface();
    $application->run();
} catch (Exception $Error) {
    Logger::log($Error->getMessage(), Logger::ERROR);
}
