<?php
namespace Bot\Internal\Managers;

use Bot\ORM\DB;
use Bot\ORM\Entities\UserEntity;
use Bot\ORM\Tables\Users;
use Bot\ORM\Tables\Ratings;

class RatingManager
{
    //directions
    const LOST_RANK = -1;
    const GAINED_RANK = 1;
    private static $registry;
    private static $ratings;
    private static $checkRequired = false;

    private static function getRatings()
    {
        if (empty(self::$ratings)) {
            $table = DB::table(Ratings::class);
            $ratings = $table->fetchMany(1, 1);
            foreach ($ratings as $rating) {
                $mmrThreshold = $rating->get(Ratings::POINTS_REQUIRED);
                $rankName = $rating->get(Ratings::RATING_NAME);
                self::$ratings[$mmrThreshold] = $rankName;
            }
        }
        return self::$ratings;
    }
    
    public static function checkRatingChanges($userId)
    {
        if (!self::$checkRequired) { 
            return false;
        }
        self::$checkRequired = false;
        $ratings = self::getRatings();
        $prevK = (int)(self::$registry[$userId]['previous'] / 1000);
        $curK = (int)(self::$registry[$userId]['current'] / 1000);
        $change = $curK - $prevK; // difference in rankings;
        if ($change === 0) {
            return false; // no changes
        }
        $newRankPoints = $curK * 1000; //for threshold search
        var_dump($newRankPoints);
        var_dump($ratings);
        $newRank = null;
        
        if (isset($ratings[$newRankPoints])) {
            $newRank = $ratings[$newRankPoints];
        }
        var_dump($newRank);
        $data = array(
            'new_rank' => $newRank,
            'direction' => $change * -1
        );
        return $data;
    }
    
    public static function updateRating($userId, $new)
    {
        if (!isset(self::$registry[$userId])) {
            self::registerRatingChanges($userId, $new);
            return false;
        }
        $previous = self::$registry[$userId]['current'];
        self::$registry[$userId] = array(
            'current' => $new,
            'previous' => $previous
        );
        self::$checkRequired = true;
        return true;
    }
    
    public static function registerRating($userId, $current)
    {
        self::$registry[$userId] = array(
            'current' => $current
        );
    }
}