<?php
namespace Core;

use Core\Tools\Config;
use Core\Tools\Debug;

class DB
{
    private static $instance;
    private $connection;
    private $dbName;

    private function __construct()
    {
        $host = Config::getOption('DBHOST');
        $login = Config::getOption('DBLOGIN');
        $password = Config::getOption('DBPASS');
		$this->dbName = Config::getOption('DBNAME');
        $this->connection = new \mysqli($host, $login, $password);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Singleton getter. Instantiate it with createInstance first
     * @return DB
     * @throws Exception
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            throw new \Exception('Create instance of Database first');
        }
        return self::$instance;
    }

    public static function createInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->createDatabase();
        }
    }

    public function createDatabase()
    {
        $dbExists = $this->connection->select_db($this->dbName);

        if (!$dbExists) {
            $this->connection->query(sprintf('CREATE DATABASE IF NOT EXISTS %s', $this->dbName));
            $this->connection->select_db($this->dbName);
            $this->createTables();
            $this->fillTablesWithValues();
        }
    }

    private function createTables()
    {
        $tables = array(
            'CREATE TABLE IF NOT EXISTS vcb_smiles (
                ID INTEGER AUTO_INCREMENT PRIMARY KEY,
                SMILE_NAME VARCHAR(255) NOT NULL,
                SMILE_PATH VARCHAR(255) NOT NULL
            );',
            'CREATE TABLE IF NOT EXISTS vcb_users (
                ID INTEGER AUTO_INCREMENT PRIMARY KEY,
                VK_USER_ID INTEGER NOT NULL,
                VK_USER_NAME VARCHAR(255) NOT NULL,
                USER_MMR INTEGER DEFAULT 2000,
                USER_LAST_MESSAGE INTEGER
            );',
            'CREATE TABLE IF NOT EXISTS vcb_ranks (
                ID INTEGER AUTO_INCREMENT PRIMARY KEY,
                RANK_NAME VARCHAR(255) NOT NULL,
                RANK_PTS_REQ INTEGER
            );'
        );
        foreach ($tables as $table) {
            $this->connection->query($table);
        }
    }

    private function fillTablesWithValues()
    {
        $queryTemplate = 'INSERT INTO %s (%s) VALUES (%s);';
        $data = array(
            'vcb_smiles' => array(
                array('SMILE_NAME' => ':пох:', 'SMILE_PATH' => 'photo-180945331_456239031'),
                array('SMILE_NAME' => ':вкурсе:', 'SMILE_PATH' => 'photo-180945331_456239032'),
                array('SMILE_NAME' => ':скибидливо:', 'SMILE_PATH' => 'photo-180945331_456239033'),
                array('SMILE_NAME' => ':нокомент:', 'SMILE_PATH' => 'photo-180945331_456239034'),
                array('SMILE_NAME' => ':скибиди:', 'SMILE_PATH' => 'photo-180945331_456239035'),
                array('SMILE_NAME' => ':матюша:', 'SMILE_PATH' => 'photo-180945331_456239036'),
                array('SMILE_NAME' => ':тохик:', 'SMILE_PATH' => 'photo-180945331_456239037'),
                array('SMILE_NAME' => ':едем:', 'SMILE_PATH' => 'photo-180945331_456239038'),
                array('SMILE_NAME' => ':свидомит:', 'SMILE_PATH' => 'photo-180945331_456239039'),
                array('SMILE_NAME' => ':э:', 'SMILE_PATH' => 'photo-180945331_456239040'),
                array('SMILE_NAME' => ':серя:', 'SMILE_PATH' => 'photo-180945331_456239041'),
                array('SMILE_NAME' => ':подробнее:', 'SMILE_PATH' => 'photo-180945331_456239042'),
                array('SMILE_NAME' => ':нытик:', 'SMILE_PATH' => 'photo-180945331_456239043'),
                array('SMILE_NAME' => ':серун:', 'SMILE_PATH' => 'photo-180945331_456239044'),
                array('SMILE_NAME' => ':никто:', 'SMILE_PATH' => 'photo-180945331_456239045'),
                array('SMILE_NAME' => ':приколюха:', 'SMILE_PATH' => 'photo-180945331_456239046'),
                array('SMILE_NAME' => ':оа:', 'SMILE_PATH' => 'photo-180945331_456239047'),
                array('SMILE_NAME' => ':постирония:', 'SMILE_PATH' => 'photo-180945331_456239048'),
                array('SMILE_NAME' => ':о:', 'SMILE_PATH' => 'photo-180945331_456239049'),
                array('SMILE_NAME' => ':ркн:', 'SMILE_PATH' => 'photo-180945331_456239050'),
                array('SMILE_NAME' => ':постирай:', 'SMILE_PATH' => 'photo-180945331_456239051'),
                array('SMILE_NAME' => ':смайл:', 'SMILE_PATH' => 'photo-180945331_456239052'),
                array('SMILE_NAME' => ':бан:', 'SMILE_PATH' => 'photo-180945331_456239053'),
                array('SMILE_NAME' => ':увожение:', 'SMILE_PATH' => 'photo-180945331_456239054'),
                array('SMILE_NAME' => ':говно:', 'SMILE_PATH' => 'photo-180945331_456239055'),
                array('SMILE_NAME' => ':рип:', 'SMILE_PATH' => 'photo-180945331_456239056'),
                array('SMILE_NAME' => ':пиздануть:', 'SMILE_PATH' => 'photo-180945331_456239057'),
                array('SMILE_NAME' => ':шут:', 'SMILE_PATH' => 'photo-180945331_456239058'),
                array('SMILE_NAME' => ':шут2:', 'SMILE_PATH' => 'photo-180945331_456239059'),
            ),
            'vcb_ranks' => array(
                array('RANK_PTS_REQ' => 1000, 'RANK_NAME' => '1k'),
                array('RANK_PTS_REQ' => 2000, 'RANK_NAME' => '2k'),
                array('RANK_PTS_REQ' => 3000, 'RANK_NAME' => '3k'),
                array('RANK_PTS_REQ' => 4000, 'RANK_NAME' => '4k'),
                array('RANK_PTS_REQ' => 5000, 'RANK_NAME' => '5k'),
                array('RANK_PTS_REQ' => 6000, 'RANK_NAME' => '6k'),
            )
        );

        foreach ($data as $tableName => $entry) {
            foreach ($entry as $value) {
                foreach ($value as &$v) {
                    $v = "'" . $v . "'";
                }
                $columns = implode(', ', array_keys($value));
                $values = implode(', ', array_values($value));
                $query = sprintf($queryTemplate, $tableName, $columns, $values);
                $this->connection->query($query);
            }
        }
    }
}
