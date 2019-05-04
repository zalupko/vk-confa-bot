<?php
namespace Bot\Internal\Controllers;

use Bot\Orm\DB;
use Bot\Orm\Table\Smiles;
use Bot\Vk\Event;
use Bot\Orm\Error\SqlQueryException;

class SmilesController
{
    private static $smileCache;
    /**
     * Returns smiles paths from DB and caches them until program execution ends.
     *
     * @param Event $event - Vk Event
     * @return array|bool
     * @throws SqlQueryException
     */
    public static function getSmiles(Event $event)
    {
        $data = array();
        $names = $event->getSmiles();
        $attachments = array();
        foreach ($names as $name) {
            if (isset(self::$smileCache[$name])) {
                $attachments[] = self::$smileCache[$name];
                continue;
            }
            $data[] = array(
                'column' => Smiles::NAME,
                'value' => $name
            );
        }
        if (empty($data)) {
            return $attachments;
        }
        $table = DB::table(Smiles::class);
        $objects = $table->fetchMany($data, true);
        foreach ($objects as $object) {
            self::$smileCache[$object->get(Smiles::NAME)] = $object->get(Smiles::PATH);
            $attachments[] = $object->get(Smiles::PATH);
        }
        return $attachments;
    }
}
