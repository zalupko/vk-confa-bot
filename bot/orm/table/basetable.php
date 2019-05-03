<?php
namespace Bot\Orm\Table;

use Bot\Orm\DB;
use Bot\Orm\Entity;
use Bot\Orm\Error\SqlQueryException;

abstract class BaseTable
{
    const ID = 'id';
    protected $table_name;

    public function fetchSingle($column, $value)
    {
        $template = "SELECT * FROM %s WHERE %s = '%s';";
        $query = sprintf($template, $this->table_name, $column, $value);
        $fetch = DB::query($query);
        if ($fetch instanceof SqlQueryException) {
            throw $fetch;
        }
        $data = $fetch->fetch_assoc();
        if ($data === null) {
            return false;
        }
        $object = new Entity($data, $this);
        return $object;
    }

    public function fetchMany($column, $values) {
        $template = 'SELECT * FROM %s WHERE %s';
        if (!is_array($values)) {
            $values = array($values);
        }
        $condition = array();
        foreach ($values as $value) {
            $condition[] = sprintf('%s = "%s"', $column, $value);
        }
        if (empty($condition)) {
            return null;
        }
        $condition = implode(' OR ', $condition);
        $query = sprintf($template, $this->table_name, $condition);
        $fetch = DB::query($query);
        if ($fetch instanceof SqlQueryException) {
            throw $fetch;
        }
        $objects = array();
        while ($data = $fetch->fetch_assoc()) {
            $objects[] = new $this->entity_name($data, $this);
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
     * @return BaseEntity|bool instance of entity or false
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
        $object = $this->fetchSingle(static::ID, $lastId);
        return $object;
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
        return $result;
    }

    protected function getMap()
    {
        $map = array();
        return $map;
    }

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
        $entityId = $entity->get(Users::ID);
        $template = 'DELETE FROM %s WHERE %s = "%s";';
        $query = sprintf($template, $this->table_name, Users::ID, $entityId);
        $result = DB::query($query);
        if ($result instanceof SqlQueryException) {
            throw $result;
        }
    }
}
