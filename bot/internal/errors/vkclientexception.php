<?php
namespace Bot\Internal\Errors;

class VkClientException extends Exception
{
    private $method;
    private $response;
    
    public function __construct(
        $message, 
        $code = null, 
        $method = null, 
        $response=array()
    ) {
        parent::__construct($message, $code);
        $this->method = $method;
        $this->response = $response;
    }
    
    public function getResponse()
    {
        $response = json_decode($this->response);
        return $response;
    }
    
    public function getMethod()
    {
        if ($this->method === null) {
            $this->method = 'undefined';
        }
        return $this->method;
    }
    
    public function getCompiled()
    {
        $compiled = sprinf(
            'VkClientError: message: %s, method: %s; err_code: %s', 
            $this->getMessage(), 
            $this->getMethod(), 
            $this->getCode()
        );
        return $compiled;
    }
}