<?php

namespace App\Services\Contracts;

use App\Models\Event;

interface EventContract
{
    /**
     * @param array $validated
     * @return Event
     */
    public function store(array $validated): Event;

    /**
     * @param Event $event
     * @return bool|null
     */
    public function destroy(Event $event): bool|null;
}
