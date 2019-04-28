<?php
namespace Bot\Commands;

use Bot\ORM\DB;
use Bot\Orm\Tables\Smiles;

class SmilesListCommand extends Command
{
    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function execute()
    {
        $smiles = DB::table(Smiles::class);
        $smileList = $smiles->fetchMany(1, 1);
        $response = array();
        foreach ($smileList as $smile) {
            $response[] = $smile->get(Smiles::SMILE_NAME);
        }
        $response = array(
            'message' => implode("\n", $response),
            'attachments' => null
        );
        return $response;
    }

    public function checkCooldown($last, $current)
    {
        // No check required
        return true;
    }
}