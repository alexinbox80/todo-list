<?php

namespace App\Services\Event;

use App\Models\Event;

class EventService
{
    /**
     * @param array $validated
     * @return Event
     */
    public function store(array $validated): Event
    {
        return new Event();
    }

    /**
     * @param Event $event
     * @return bool|null
     */
    public function destroy(Event $event): bool|null
    {
        return false;
    }
}
