<?php
ini_set('display_errors', 'On');
use Core\Application;
use Core\Utils\Logger;
use Core\Utils\RuntimeTracker;
use Core\Utils\Upgrader;
require_once('core/utils/autoloader.php');

/* Логика такова:
 * Класс Ядро включает в себя всё, что будет использовано в 100% случаев.
 * Класс ЛонгПоллинг должен уметь получать сервер и получать события с сервера, а также обновлять инфу о сервере
 * Класс ВкКлиент должен уметь отправлять и получать инфу используя ВК АПИ
 * Класс ОРМ не планируется к реалзиации, вместо него можно использовать стандартые SQL запросы
 * Класс загрузчик модулей - устарел
 * Класс фабрика модулей - устарел
 * Класс Роутер - устарел
 */

$application = new Application();
try {
    RuntimeTracker::checkIdentifier();
    Upgrader::doUpgrade();
    $application->run();
} catch (Exception $Error) {
    Logger::log($Error->getMessage());
}
