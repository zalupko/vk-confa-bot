<?php
class ModuleLoader
{
	const ESSENTIALS = array('EventResolver');
	const MODULE_PATH = '/core/modules/';
	private static $instance;
	private $loadPool;

	private function __construct() 
	{
		$this->loadPool = array();
	}

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new static();
		}
		return self::$instance;
	}

	public function load($moduleName)
	{
		$filepath = $this->classToFilePath($moduleName);
		$realFilepath = realpath($filepath);
		$loadStatus = false;
		if (!$this->checkModule($moduleName) && $realFilepath !== false) {
			require_once($realFilePath);
			$loadStatus = true;
		}
		$this->updateLoadPool($moduleName, $status);
	}

	private function classToFilePath($className)
	{
		$filename = strtolower($className) . '.php';
		$filepath = $_SERVER['DOCUMENT_ROOT'] . self::MODULE_PATH . $filename;
		return $filepath;
	}

	public function checkModule($moduleName)
	{
		$check = false;
		if (isset($this->loadPool[$moduleName]) && $this->loadPool[$moduleName] == true) {
			$check = true;
		}
		return $check;
	}

	private function updateLoadPool($moduleName, $status)
	{
		$this->loadPool[$moduleName] = $status;
	}
}
