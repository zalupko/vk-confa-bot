<?php
namespace Bot\Commands;

abstract class Command
{
    protected $data;
    abstract public function execute();
}