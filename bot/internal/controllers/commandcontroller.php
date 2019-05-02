<?php
namespace Bot\Internal\Controllers;

use Bot\Commands\Base;
use Bot\Vk\Event;
use Bot\Commands\TestCommand;

class CommandController
{
    private static $commands = array(
        'test' => TestCommand::class
    );

    private static function determineCommand($string)
    {
        foreach (self::$commands as $name => $class)
        {
            if (strpos($string, $name) !== false) {
                return $class;
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
            'sender' => $event->getSender(),
            'mention' => $event->getMention(),
            'date' => $event->getDate()
        );
        return new $class($data);
    }
}