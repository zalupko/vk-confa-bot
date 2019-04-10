<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/application.php');

$application = Application::getInstance();
$application->initEssentials();

$moduleLoader = $application->getModuleLoader();

$eventResolver = $application->getEventResolver();
$event = $eventResolver->getEvent();

// Базовый обход возможных callback событий.
switch $event->getName() {
	case EventResolver::TEST_EVENT:
		$moduleLoader->load('');
	default:
		break;
}