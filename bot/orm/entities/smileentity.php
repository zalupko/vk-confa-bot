<?php
namespace Bot\ORM\Entities;

use Bot\Orm\Tables\Smiles;

class SmileEntity extends Entity
{
    protected $id;
    protected $data;
    protected $table;

    public function __construct($data, $table)
    {
        parent::__construct($data, $table);
        $this->id = $data[Smiles::ID];
    }
}