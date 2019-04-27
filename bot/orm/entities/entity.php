<?php
namespace Bot\ORM\Entities;

abstract class Entity
{
    protected $data;
    protected $id;
    protected $table;

    protected function __construct($data, $table)
    {
        $this->data = $data;
        $this->table = $table;
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

    public function save()
    {
        $data = $this->table->update($this->id, $this->data);
        $this->data = $data;
    }
}