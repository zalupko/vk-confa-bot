<?php
namespace Bot\ORM;

use mysqli;
use Bot\Tools\Config;
use Bot\ORM\Tables\Table;

/**
 * Class DB
 * @var mysqli $connection - database connection instance
 * @package Bot\ORM
 */
class DB
{
    const NOT_TABLE_CLASSNAME = 'Given classname is not a table';
    private static $connection;
    private static $dbname;
    private static $tables_cache;

    /**
     * @return mysqli MySQL connection instance
     * @throws \Exception
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            self::initializeConnection();
        }
        return self::$connection;
    }

    private static function initializeConnection()
    {
        $data = array(
            'HOST' => Config::getOption('DBHOST'),
            'LOGIN' => Config::getOption('DBLOGIN'),
            'PASSWORD' => Config::getOption('DBPASS'),
            'DBNAME' => Config::getOption('DBNAME')
        );
        self::$connection = new mysqli($data['HOST'], $data['LOGIN'], $data['PASSWORD']);
        if (self::$connection->connect_error !== null) {
            throw new \Exception(
                self::$connection->connect_error,
                self::$connection->connect_errno
            );
        }
        self::$dbname = $data['DBNAME'];
        self::$connection->select_db(self::$dbname);
    }

    public static function disconnect()
    {
        self::$connection->close();
    }

    public static function query($query)
    {
        $connection = self::getConnection();
        $fetch = $connection->query($query);
        if ($fetch === false) {
            $error = array(
                'error' => $connection->error,
                'code' => $connection->errno
            );
            return new Error($error);
        }
        return $fetch;
    }

    public static function table($tableName)
    {
        if (!isset(self::$tables_cache[$tableName])) {
            $table = new $tableName();
            if (!($table instanceof Table)) {
                throw new \Exception(self::NOT_TABLE_CLASSNAME);
            }
            self::$tables_cache[$tableName] = $table;
        }
        return self::$tables_cache[$tableName];
    }
}