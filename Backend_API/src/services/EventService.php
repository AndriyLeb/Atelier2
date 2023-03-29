<?php


namespace reunionou\services;

use reunionou\models\Event;

class EventService {

    public static function getEventById(int $id): ?array
    {
        $event = Event::select('id', 'title', 'description', 'latitude', 'longitude', 'street', 'zipcode', 'city', "organizer_id", "created_at")
        ->where('id', '=', $id)
        ->first();
    
        return $event ? $event->toArray() : null;
    }
    
    public static function getAllEvents(): ?array
    {
        $events = Event::select('id', 'title', 'description', 'latitude', 'longitude', 'street', 'zipcode', 'city', "organizer_id", "created_at")
        ->get();
    
        return $events ? $events->toArray() : null;
    }

}