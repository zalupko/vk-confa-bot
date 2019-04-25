<?php
namespace Bot\ORM\Entities;

use Bot\ORM\Tables\User;

class UserEntity extends Entity
{
    protected $data;
    private $id;
    private $table;

    public function __construct($table, $data)
    {
        parent::__construct($data);
        $this->id = $data[User::ID];
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