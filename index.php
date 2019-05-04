<?php
use Bot\Application;
use Bot\Internal\Tools\Logger;
use Bot\Internal\Tools\Debug;
require_once('bot/internal/autoloader.php');

$application = new Application();

try {
    $application->checkInterface();
    $application->run();
} catch (Throwable $error) {
    Debug::dump($error, 'CAUGHT_ERROR');
    Logger::log($error->getMessage(), Logger::ERROR);
    Logger::closeFile();
}