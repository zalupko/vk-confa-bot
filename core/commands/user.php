<?php
namespace Core\Commands;

use Core\Utils\Debug;

class User extends Command
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        $data = $this->data;
        if (!isset($data['id'])) {
            return false;
        }
        $info = \Core\User::getUserInfo($data['id']);
        return json_encode($info);
    }
}