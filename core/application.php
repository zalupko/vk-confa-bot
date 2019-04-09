<?php
class Application
{
	private static $instance;
	private $eventResolver;
	private function __construct() 
	{

	}

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new static();
		}
		return self::$instance;
	}

	public function initEssentials()
	{
		
	}

	public function getEventResolver()
	{
 		if ($this->eventResolver === null) {
			$this->eventResolver = new EventResolver();
		}
		return $this->eventResolver;
	}
}
