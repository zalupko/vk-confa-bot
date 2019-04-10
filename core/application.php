<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/core/moduleloader.php');

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
		$loader = ModuleLoader::getInstance();
		foreach (ModuleLoader::ESSENTIALS as $essential) {
			$loader->loadModule($essential);
		}
	}

	public function getEventResolver()
	{
 		if ($this->eventResolver === null) {
			$this->eventResolver = new EventResolver();
		}
		return $this->eventResolver;
	}
	
	public function getModuleLoader()
	{
		if ($this->moduleLoader === null) {
			$this->moduleLoader = ModuleLoader::getInstance();
		}
		return $this->moduleLoader;
	}
}
