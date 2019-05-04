<?php
namespace Bot\Commands;

use Bot\Orm\DB;
use Bot\Orm\Table\Smiles;

class SmileListCommand extends Base
{
    public function execute()
    {
        $smiles = DB::table(Smiles::class);
        $smileList = $smiles->fetchSingle(1, 1, '=', true);
        $message = array();
        foreach ($smileList as $smile) {
            $message[] = $smile->get(Smiles::NAME);
        }
        $message = implode("\n", $message);
        return $this->getCompiled($message);
    }

    public function checkCooldown($last, $current)
    {
        return 0;
    }
}