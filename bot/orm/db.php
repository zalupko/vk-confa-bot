<?php
namespace Bot\Orm;

use Bot\Orm\Error\SqlConnectionException;
use Bot\Orm\Error\SqlQueryException;
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
    }
}