<?php
namespace Bot\ORM\Errors;

use Exception;

class SqlQueryException extends Exception
{
    private $query;

    public function __construct($error, $query = '')
    {
        $message = $error['error'];
        $code = $error['code'];
        parent::__construct($message, $code);
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }
}