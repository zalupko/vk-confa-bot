<?php
namespace Bot\ORM\Tables;

use Bot\ORM\DB;
use Bot\ORM\Entities\Entity;
use Bot\ORM\Error;

abstract class Table
{
    const ID = 'id';
    protected $table_name;

    protected function fetchSingle($column, $value)
    {
        $template = 'SELECT * FROM %s WHERE %s = "%s"';
        $query = sprintf($template, $this->table_name, $column, $value);
        $fetch = DB::query($query);
        return $fetch;
    }

    protected function fetchMany($column, $values) {
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
        return $fetch;
    }

    public function update($id, $data)
    {
        $queryTemplate = 'UPDATE %s SET %s WHERE %s';
        $qualTemplate = '%s = "%s"';
        $updates = array();
        foreach ($data as $column => $item) {
            $updates[] = sprintf($qualTemplate, $column, $item);
        }
        $update = implode(', ', $updates);
        $condition = sprintf($qualTemplate, static::ID, $id);
        $query = sprintf($queryTemplate, $this->table_name, $update, $condition);
        $result = DB::query($query);
        if ($result instanceof Error) {
            throw new \Exception($result->getError(), $result->getCode());
        }
        return $data;
    }
}