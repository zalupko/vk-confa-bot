<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/application.php');

$application = Application::getInstance();
$application->initEssentials();

$eventResolver = $application->getEventResolver();
$event = $eventResolver->getEvent();