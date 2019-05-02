<?php
namespace Bot\Orm\Error;

use Exception;

class SqlQueryException extends Exception
{
    public function __construct($message, $code) {
        parent::__construct($message, $code);
    }
}