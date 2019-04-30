<?php
namespace Bot\ORM\Tables;

use Bot\ORM\Entities\RatingEntity;

class Ratings extends Table
{
    const ID = 'id';
    const RATING_NAME = 'rating_name';
    const POINTS_REQUIRED = 'points_required';
    protected $table_name = 'vcb_ratings';
    protected $entity_name = RatingEntity::class;

    protected function getMap()
    {
        $map = array(
            self::ID => array(
                'type' => 'INTEGER',
                'autoincrement' => true,
                'primary' => true
            ),
            self::RATING_NAME => array(
                'type' => 'VARCHAR(255)',
                'null' => false
            ),
            self::POINTS_REQUIRED => array(
                'type' => 'INTEGER',
                'null' => false
            )
        );
        return $map;
    }
}