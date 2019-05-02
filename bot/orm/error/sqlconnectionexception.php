<?php
namespace Bot\Orm\Error;

use Exception;

class SqlConnectionException extends Exception
{
    public function __construct($message, $code) {
        parent::__construct($message, $code);
    }
}