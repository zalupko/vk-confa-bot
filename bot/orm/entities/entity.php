<?php
namespace Bot\ORM\Entities;

abstract class Entity
{
    protected $data;

    protected function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function get($column);
    abstract public function set($column, $value);
    abstract public function save();
}