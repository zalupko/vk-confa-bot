<?php
namespace Bot\ORM\Entities;

use Bot\ORM\Tables\Ratings;

class RatingEntity extends Entity
{
    protected $data;
    protected $id;
    protected $table;

    public function __construct($data, $table)
    {
        parent::__construct($data, $table);
        $this->id = $data[Ratings::ID];
    }
}