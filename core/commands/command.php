<?php
namespace Core\Commands;

abstract class Command
{
    protected $data;
    abstract public function execute();
}