<?php
namespace Bot\Orm;

use Bot\Orm\Error\SqlConnectionException;
use Bot\Orm\Error\SqlQueryException;
use mysqli;
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

    public static function connect()
    {
        $dblogin = Config::getOption('DBLOGIN');
        $dbpassword = Config::getOption('DBPASS');
        $dbhost = Config::getOption('DBHOST');
        self::$dbname = Config::getOption('DBNAME');
        self::$connection = new mysqli($dbhost, $dblogin, $dbpassword);
    }

    public static function disconnect()
    {
        self::$connection->close();
    }

    /**
     * @param string $query
     * @throws SqlConnectionException
     */
    public static function query($query)
    {
        $result = self::$connection->query($query);
        if ($result === false) {
            throw new SqlConnectionException(
                self::$connection->connect_error,
                self::$connection->connect_errno
            );
        }
    }

    /**
     * @throws SqlConnectionException
     */
    public static function createDatabase()
    {
        $query = 'CREATE DATABASE '.self::$dbname.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;';
        self::query($query);
    }
}