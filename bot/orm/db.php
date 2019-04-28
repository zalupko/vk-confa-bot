<?php
namespace Bot\ORM;

use mysqli;
use Bot\ORM\Errors\SqlConnectionException;
use Bot\ORM\Errors\SqlQueryException;
use Bot\Tools\Config;
use Bot\ORM\Tables\Table;

/**
 * Class DB - Controls Database
 * @var mysqli $connection - database connection instance
 * @package Bot\ORM
 */
class DB
{
    const NOT_TABLE_CLASSNAME = 'Given classname is not a table';
    private static $connection;
    private static $dbname;
    private static $tables_cache;
    private static $exists = false;

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
            throw new SqlConnectionException(
                self::$connection->connect_error,
                self::$connection->connect_errno
            );
        }
        self::$dbname = $data['DBNAME'];
        self::$exists = self::selectDatabase();
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
            return new SqlQueryException($error);
        }
        return $fetch;
    }

    public static function selectDatabase()
    {
        if (!self::$exists) {
            $query = 'CREATE DATABASE '.self::$dbname.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;';
            self::query($query);
        }
        return self::$connection->select_db(self::$dbname);
    }

    /**
     * @param $tableName
     * @return Table
     * @throws \Exception
     */
    public static function table($tableName)
    {
        if (!isset(self::$tables_cache[$tableName])) {
            if (!is_subclass_of($tableName, Table::class, true)) {
                throw new \Exception(self::NOT_TABLE_CLASSNAME);
            }
            $table = new $tableName();
            self::$tables_cache[$tableName] = $table;
        }
        return self::$tables_cache[$tableName];
    }

    public static function drop()
    {
        self::getConnection();
        $query = 'DROP DATABASE '.self::$dbname;
        self::$connection->query($query);
    }
}