<?php
namespace Bot\ORM\Entities;

use Bot\ORM\Tables\Options;

class OptionEntity extends Entity
{
    protected $data;
    protected $id;
    protected $table;

    public function __construct($data, $table)
    {
        parent::__construct($data, $table);
        $this->id = $data[Options::ID];
    }
}