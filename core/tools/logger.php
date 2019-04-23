<?php
namespace Core\Tools;

class Logger
{
    const LOG_MODE = 'a';
    const DEBUG = 0;
    const INFO = 1;
    const WARNING = 2;
    const ERROR = 3;

    private static $logLevels = array(
        'DEBUG', 'INFO', 'WARNING', 'ERROR'
    );

    public static function log($logMessage, $logLevel = self::DEBUG, $logFile = '__log.log')
    {
        $file = fopen($logFile, self::LOG_MODE);
        $level = Config::getOption('LOG_LEVEL', self::ERROR);
        if ($logLevel >= $level) {
            $message = self::$logLevels[$logLevel] . ': ' . $logMessage . PHP_EOL;
            fwrite($file, $message);
        }
        fclose($file);
    }
}
