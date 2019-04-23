<?php
ini_set('display_errors', 'On');
use Core\Application;
use Core\Tools\Logger;
use Core\Tools\RuntimeTracker;
use Core\Tools\Upgrader;
require_once('core/tools/autoloader.php');

$application = new Application();
try {
    Upgrader::doUpgrade();
	$application->checkInterface();
    $application->run();
} catch (Exception $Error) {
    Logger::log($Error->getMessage());
}
