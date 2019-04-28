<?php
namespace Bot\ORM\Entities;

use Bot\ORM\Tables\User;

class UserEntity extends Entity
{
    protected $data;
    protected $id;
    protected $table;

    public function __construct($data, $table)
    {
        parent::__construct($data, $table);
        $this->id = $data[User::ID];
    }
}