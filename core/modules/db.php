<?php
class DataBase
{
	private static $instance;
	private $connection;
	
	private function __construct()
	{
		require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

	}
	
	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new static();
		}
		return self::$instance;
	}
	
	public function connect()
	{
		if ($this->connection === null) {
			$this->connection = new mysqli(
				$dbConnection['HOST'], $dbConnection['USERNAME'], $dbConnection['PASSWORD'], $dbConnection['DBNAME']
			);
		}
		return $this->connection;
	}
	
	public function disconnect()
	{
		$this->connection->close();
	}
	
	public function query($queryString, $params)
	{
		$params = $this->prepareQuery($params);
	}
	
	private function prepareQuery($params)
	{
		foreach ($params as &$param) {
			$param = $this->connection->real_escape_string($param);
		}
	}
}

class DataBaseResult
{
	private $result;
	public function __construct($dbResult)
	{
		$this->result = $dbResult;
	}
	
	public function fetch()
	{
		if ($this->result === null) {
			return false;
		}
	}
	
	public function fetchAll()
	{
		if ($this->result === null) {
			return false;
		}
	}
}