<?php
namespace Bot\Orm;

use Bot\Internal\Tools\Debug;
use Bot\Internal\Tools\Logger;
use InvalidArgumentException;
use Bot\Orm\Error\SqlConnectionException;
use Bot\Orm\Error\SqlQueryException;
use Bot\Orm\Table\BaseTable;
use mysqli;
use mysqli_result;
use Bot\Internal\Tools\Config;

/**
 * Class DB
 * @package Bot\Orm
 */
class DB
{
    /**
     * @var mysqli $connection instance of class mysqli
     */
    private static $connection;
    private static $dbname;
    private static $table_cache;

    /**
     * @throws SqlConnectionException
     */
    public static function connect()
    {
        $dblogin = Config::getOption('DBLOGIN');
        $dbpassword = Config::getOption('DBPASS');
        $dbhost = Config::getOption('DBHOST');
        self::$dbname = Config::getOption('DBNAME');
        self::$connection = new mysqli($dbhost, $dblogin, $dbpassword);
        Logger::log('Established connection to mysql server', Logger::DEBUG);

        if (self::$connection->connect_error) {
            throw new SqlConnectionException(
                self::$connection->connect_error,
                self::$connection->connect_errno
            );
        }
    }

    public static function disconnect()
    {
        self::$connection->close();
        Logger::log('Disconnected from mysql server', Logger::DEBUG);
    }

    /**
     * @param string $query
     * @return SqlQueryException|mysqli_result
     */
    public static function query($query)
    {
        $result = self::$connection->query($query);
        if ($result === false) {
            return new SqlQueryException(
                self::$connection->error,
                self::$connection->errno
            );
        }
        return $result;
    }

    /**
     * Enconding to UTF-8 is required because of russian characters in charset
     */
    public static function createDatabase()
    {
        $query = 'CREATE DATABASE '.self::$dbname.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;';
        self::query($query);
        self::$connection->select_db(self::$dbname);
        Logger::log('Installed database successfully', Logger::DEBUG);
    }

    /**
     * @return bool true if database exists; false otherwise
     */
    public static function dbExists()
    {
        $exists = self::$connection->select_db(self::$dbname);
        return $exists;
    }

    /**
     * @param string $tableName - FQN of required table, use Table::class to get table object
     * @return BaseTable $table - instance of BaseTable
     */
    public static function table($tableName)
    {
        $isTable = is_subclass_of($tableName, BaseTable::class, true);
        if (!$isTable) {
            throw new InvalidArgumentException($tableName . ' is not a table');
        }
        if (!isset(self::$table_cache[$tableName])) {
            self::$table_cache[$tableName] = new $tableName();
        }
        Logger::log('Created object of '.$tableName, Logger::DEBUG);
        return self::$table_cache[$tableName];
    }
}