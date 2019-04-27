<?php
namespace Bot\ORM\Errors;

use Exception;

class SqlConnectionException extends Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}