<?php
namespace Bot\Orm\Table;

use Bot\Internal\Tools\Logger;
use Bot\Orm\DB;
use Bot\Orm\Entity;
use Bot\Orm\Error\SqlQueryException;

abstract class BaseTable
{
    const ID = 'id';
    protected $table_name;

    /**
     * Fetches only one object with "... WHERE $column $condition '$value'" query
     * TODO: add sorting modifiers
     * @param string $column
     * @param string $value
     * @param string $condition
     * @param bool $multiple - (Optional) true if should return array of objects, false if only one object should be returned
     * @return Entity|array - see multiple
     * @throws SqlQueryException
     */
    public function fetchSingle($column, $value, $condition = '=', $multiple = false)
    {
        $template = "SELECT * FROM %s WHERE %s %s '%s';";
        $query = sprintf($template, $this->table_name, $column, $condition, $value);
        $fetch = DB::query($query);
        if ($fetch instanceof SqlQueryException) {
            throw $fetch;
        }
        if (!$multiple) {
            $data = $fetch->fetch_assoc();
            return new Entity($data, $this);
        }
        $objects = array();
        while ($data = $fetch->fetch_assoc()) {
            $objects[] = new Entity($data, $this);
        }
        return $objects;
    }

    /**
     * Allows fetching by many conditions (multiple columns, multiple values, multiple conditions)
     * Conditions are connected via OR logical operator by default. This value cannot be changed
     * TODO: add logical connection modifier
     * @param array $data
     * @param bool $multiple - (Optional) true if should return array of objects, false if only one object should be returned
     * @return Entity|array - See multiple
     * @throws SqlQueryException
     */
    public function fetchMany($data, $multiple = false) {
        $template = 'SELECT * FROM %s WHERE %s';
        $conditions = array();
        foreach ($data as $instance) {
            $column = $instance['column'];
            $value = $instance['value'];
            $condition = isset($instance['condition']) ? $instance['condition'] : '=';
            $conditions[] = sprintf("%s %s '%s'", $column, $condition, $value);
        }
        $conditions = implode(' OR ', $conditions);
        $query = sprintf($template, $this->table_name, $conditions);
        $fetch = DB::query($query);
        if ($fetch instanceof SqlQueryException) {
            throw $fetch;
        }
        if (!$multiple) {
            $data = $fetch->fetch_assoc();
            return new Entity($data, $this);
        }
        $objects = array();
        while ($data = $fetch->fetch_assoc()) {
            $objects[] = new Entity($data, $this);
        }
        return $objects;
    }

    public function update($id, $data)
    {
        $queryTemplate = 'UPDATE %s SET %s WHERE %s';
        $qualTemplate = "%s = '%s'";
        $updates = array();
        foreach ($data as $column => $item) {
            $updates[] = sprintf($qualTemplate, $column, $item);
        }
        $update = implode(', ', $updates);
        $condition = sprintf($qualTemplate, static::ID, $id);
        $query = sprintf($queryTemplate, $this->table_name, $update, $condition);
        $result = DB::query($query);
        if ($result instanceof SqlQueryException) {
            throw $result;
        }
        return $data;
    }

    /**
     * @param $data
     * @return int|bool id of insertion or false otherwise
     * @throws SqlQueryException
     */
    public function add($data)
    {
        $template = 'INSERT INTO %s (%s) VALUES (%s);';
        $columns = array();
        $values = array();
        foreach ($data as $column => $value) {
            $columns[] = $column;
            $values[] = "'".$value."'";
        }
        $columns = implode(', ', $columns);
        $values = implode(', ', $values);
        $query = sprintf($template, $this->table_name, $columns, $values);
        $result = DB::query($query);
        if ($result instanceof SqlQueryException) {
            throw $result;
        }
        $lastId = $this->getLastId();
        return $lastId;
    }

    public function create()
    {
        $map = $this->getMap();
        $template = 'CREATE TABLE IF NOT EXISTS %s (%s)';
        $columns = array();
        foreach ($map as $name => $properties) {
            $column = array($name);
            if (isset($properties['type'])) {
                $column[] = strtoupper($properties['type']);
            }
            if (isset($properties['autoincrement']) && $properties['autoincrement'] == true) {
                $column[] = 'AUTO_INCREMENT';
            }
            if (isset($properties['primary']) && $properties['primary'] == true) {
                $column[] = 'PRIMARY KEY';
            }
            if (isset($properties['unique']) && $properties['unique'] === true) {
                $column[] = 'UNIQUE';
            }
            if (isset($properties['default'])) {
                $column[] = 'DEFAULT '.$properties['default'];
            }
            if (isset($properties['null']) && $properties['null'] == false) {
                $column[] = 'NOT NULL';
            }
            $columns[] = implode(' ', $column);
        }
        $columns = implode(', ', $columns);
        $query = sprintf($template, $this->table_name, $columns);
        $result = DB::query($query);
        Logger::log('Created table '.$this->table_name.' successfully', Logger::DEBUG);
        return $result;
    }

    abstract protected function getMap();

    protected function getLastId()
    {
        $query = 'SELECT LAST_INSERT_ID();';
        $result = DB::query($query);
        if ($result instanceof SqlQueryException) {
            throw $result;
        }
        $result = $result->fetch_array();
        return array_shift($result);
    }

    public function delete($entity)
    {
        $entityId = $entity->get(static::ID);
        $template = 'DELETE FROM %s WHERE %s = "%s";';
        $query = sprintf($template, $this->table_name, Users::ID, $entityId);
        $result = DB::query($query);
        if ($result instanceof SqlQueryException) {
            throw $result;
        }
    }
}
