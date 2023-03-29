<?php


namespace reunionou\services;

use reunionou\models\Participant;

class ParticipantService {

    public static function getParticipantsByEventId(int $event_id): ?array
    {
        $participants = Participant::select('id', 'event_id', 'user_id', 'firstname', 'lastname', 'email', 'status', 'created_at')
        ->where('event_id', '=', $event_id)
        ->get();
    
        return $participants ? $participants->toArray() : null;
    }
    
}