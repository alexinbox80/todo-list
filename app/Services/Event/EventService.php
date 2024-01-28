<?php

namespace App\Services\Event;

use App\Enums\TaskEvent;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class EventService
{
    /**
     * @param array $validated
     * @return Event|null
     */
    public function store(array $validated): Event|null
    {
        $task = Task::find($validated['task_id']);
        if ($task->user_id === Auth::id()) {
            $event = Event::create(
                $validated
            );

            return $event;
        } else
            return null;
    }

    /**
     * @param Event $event
     * @return bool|null
     */
    public function destroy(Event $event): bool|null
    {
        $task = Task::find($event->getAttribute('task_id'));
        if ($task->user_id === Auth::id()) {
            return $event->delete();
        } else
            return null;
    }
}
