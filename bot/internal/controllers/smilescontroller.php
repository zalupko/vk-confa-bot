<?php
namespace Bot\Internal\Controllers;

use Bot\Internal\Tools\Debug;
use Bot\Orm\DB;
use Bot\Orm\Table\Smiles;
use Bot\Vk\Event;
use Bot\Orm\Error\SqlQueryException;

class SmilesController
{
    /**
     * @param Event $event - Vk Event
     * @return array|bool
     * @throws SqlQueryException
     */
    public static function getSmiles(Event $event)
    {
        $data = array();
        $names = $event->getSmiles();
        Debug::dump($names, 'SMILE_NAMES', true);
        foreach ($names as $name) {
            $data[] = array(
                'column' => Smiles::NAME,
                'value' => $name
            );
        }
        if (empty($data)) {
            return false;
        }
        $table = DB::table(Smiles::class);
        $objects = $table->fetchMany($data, true);
        $attachments = array();
        foreach ($objects as $object) {
            $attachments[] = $object->get(Smiles::PATH);
        }
        return $attachments;
    }
}
