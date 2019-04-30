<?php
namespace Bot\Internal\Managers;

use Bot\Command\Command;
use Bot\Commands\SmilesListCommand;
use Bot\Commands\TestCommand;
use Bot\Commands\ScytheCommand;
use Bot\Commands\StatsCommand;
use Bot\Commands\BattleCommand;

class CommandManager
{
    private static $actionPool = array(
        'тест' => TestCommand::class,
        'коса' => ScytheCommand::class,
        'смайлы' => SmilesListCommand::class,
        'катка' => BattleCommand::class,
        'стата' => StatsCommand::class
    );

    private static function determineCommand($action)
    {
        foreach (self::$actionPool as $name => $command) {
            if (strpos($action, $name) !== false) {
                return $command;
            }
        }
        return false;
    }

    /**
     * @return Command|bool $command Command Object
     */
    public static function getCommandObject($action, $data)
    {
        $command = self::determineCommand($action);
        if (!$command) {
            return false;
        }
        return new $command($data);
    }
}
