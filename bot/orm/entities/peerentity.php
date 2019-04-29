<?php
namespace Bot\ORM\Entities;

use Bot\ORM\Tables\Peers;

class PeerEntity extends Entity
{
    protected $data;
    protected $id;
    protected $table;
    
    public function __construct($data, $table) {
        parent::__construct($data, $table);
        $this->id = $data[Peers::ID];
    }
}
