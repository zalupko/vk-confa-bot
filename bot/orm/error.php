<?php
namespace Bot\ORM;

class Error
{
    private $error;
    private $code;

    public function __construct($errorData)
    {
        $this->error = $errorData['error'];
        $this->code = $errorData['code'];
    }

    public function getError()
    {
        return $this->error;
    }

    public function getCode()
    {
        return $this->code;
    }
}