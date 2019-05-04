<?php
namespace Bot\Internal\Controllers;

use Bot\Commands\Base;
use Bot\Vk\Event;
use Bot\Commands\TestCommand;
use Bot\Commands\SmileListCommand;

class CommandController
{
    private static $commands = array(
        TestCommand::class => array(
            'test', 'тест', 'конфа тест', 'конфа test'
        ),
        SmileListCommand::class => array(
            'smiles', 'конфа смайлы'
        )
    );

    private static function determineCommand($string)
    {
        foreach (self::$commands as $class => $names) {
            foreach ($names as $name) {
                if (strpos($string, $name) === 0) {
                    return $class;
                }
            }
        }
        return false;
    }

    /**
     * @param Event $event
     * @return Base|bool $class returns command object
     */
    public static function getCommandObject(Event $event)
    {
        $class = self::determineCommand($event->getText());
        if (!$class) {
            return false;
        }
        $data = array(
            'peer' => $event->getPeer(),
            'sender' => $event->getSender(),
            'mention' => $event->getMention(),
            'date' => $event->getDate(),
        );
        return new $class($data);
    }
}