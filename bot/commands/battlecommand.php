<?php
namespace Bot\Commands;

class BattleCommand extends Command
{
    protected $data;
    const PTS_DIFF = 25;
    const MIN_CHANCE = 20;
    const BASE_CHANCE = 50;
    const MAX_CHANCE = 70;
    const COOLDOWN = 30;

    public function execute()
    {

    }

    public function checkCooldown($last, $current)
    {
        $time = $current - $last;
        return self::COOLDOWN - $time;
    }
}