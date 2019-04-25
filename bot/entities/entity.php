<?php
namespace Bot\Entities;

use Bot\DB;

abstract class Entity
{
    const ID_COLUMN = 'id';

    protected $tableName;
    protected $connection;
    protected $error;
    protected $raw;

    public function __construct($id)
    {
        $this->connection = DB::getInstance()->getConnection();
        $query = 'SELECT * FROM '.$this->tableName.' WHERE '.static::ID_COLUMN. ' = "'.$id. '"';
        $status = $this->connection->query($query);
        if ($status === false) {
            $this->error = array(
                'error' => $this->connection->error,
                'code' => $this->connection->errno
            );
        } else {
            $this->raw = $status->fetch_assoc();
        }
        $this->sync();
    }

    abstract public function get($columnName);
    abstract public function set($columnName, $value);
    abstract public function sync();
}