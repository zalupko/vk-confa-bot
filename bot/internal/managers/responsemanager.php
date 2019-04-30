<?php
namespace Bot\Internal\Managers;

use \Bot\ORM\DB;
use Bot\ORM\Tables\Responses;

class ResponseManager
{ 
    public static function getResponses($responseType)
    {
        $table = DB::table(Responses::class);
        $responses = $table->fetchMany(Responses::RESPONSE_TYPE, $responseType);
        return $responses;
    }
    
    public static function getRandomResponse($responseType)
    {
        $responses = self::getResponses($responseType);
        if (empty($responses)) {
            throw new \Exception('Response "'.$responseType.'" not found');
        }
        $randomId = array_rand($responses);
        $responseObject = $responses[$randomId];
        $context = $responseObject->get(Responses::RESPONSE_CONTEXT);
        return $context;
    }
}