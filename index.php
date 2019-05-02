<?php
use Bot\Application;
use Bot\Internal\Tools\Logger;
require_once('bot/internal/autoloader.php');

$application = new Application();

try {
    $application->checkInterface();
    $application->run();
} catch (Throwable $error) {
    Logger::log($error->getMessage(), Logger::ERROR);
    Logger::closeFile();
}