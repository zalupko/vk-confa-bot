<?php
namespace Bot\Internal\Tools;

class Debug
{
    const LABEL_TEMPLATE = "Label: %s".PHP_EOL;
    const ADDITIONAL_TEMPLATE = "File: %s; Line: %s".PHP_EOL;

    public static function dump($variable, $label=null, $additional=null)
    {
        ob_start();
        var_dump($variable);
        $message = ob_get_clean();
        if (isset($label)) {
            $message .= sprintf(self::LABEL_TEMPLATE, $label);
        }
        if (isset($additional) && $additional === true) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $file = $trace[0]['file'];
            $line = $trace[0]['line'];
            $message .= sprintf(self::ADDITIONAL_TEMPLATE, $file, $line);
        }
        echo $message;
    }
}