<?php
namespace Bot\Orm;

use Bot\Orm\Table\BaseTable;
use Bot\Orm\Error\SqlQueryException;

class Entity
{
    protected $data;
    protected $id;
    protected $table;

    /**
     * BaseEntity constructor.
     * @param array $data
     * @param BaseTable $table
     */
    public function __construct($data, $table)
    {
        $this->data = $data;
        $this->table = $table;
        $this->id = $data[$table::ID];
    }

    public function get($column)
    {
        return $this->data[$column];
    }

    public function set($column, $value)
    {
        $this->data[$column] = $value;
        return $this;
    }

    /**
     * @throws SqlQueryException
     */
    public function save()
    {
        $data = $this->table->update($this->id, $this->data);
        $this->data = $data;
    }
}