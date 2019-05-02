<?php
namespace Bot\Internal\Tools;

class Logger
{
    private static $logLevels = array(
        'DEBUG', 'INFO', 'WARNING', 'ERROR'
    );
    private static $logFile;
    const DEBUG = 0;
    const INFO = 1;
    const WARNING = 2;
    const ERROR = 3;
    const LOG_FILENAME = '__log.log';

    public static function getFile()
    {
        if (self::$logFile === null) {
            self::$logFile = fopen(self::LOG_FILENAME, 'a');
        }
        return self::$logFile;
    }

    public static function log($message, $logLevel)
    {
        $config = Config::getOption('LOG_LEVEL');
        if ($logLevel >= $config) {
            $messageTemplate = "<%s> %s: msg: %s\n";
            $entry = sprintf(
                $messageTemplate,
                time(),
                self::$logLevels[$logLevel],
                $message
            );
            fwrite(self::getFile(), $entry);
        }
    }

    public static function closeFile()
    {
        fclose(self::$logFile);
    }
}