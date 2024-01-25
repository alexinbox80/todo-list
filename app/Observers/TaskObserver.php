<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "creating" event.
     */
    public function creating(Task $task): void
    {
        $event = Event::where([
                'task_id' => $task->id,
                'type_event' => 'creating'
            ])->first();
        Log::info(__CLASS__ . ' () ' . json_encode(['creating', $event]) . PHP_EOL);
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Log::info(__CLASS__ . ' () ' . json_encode('created') . PHP_EOL);
    }

    /**
     * Handle the Task "updating" event.
     */
    public function updating(Task $task): void
    {
        Log::info(__CLASS__ . ' () ' . json_encode('updating') . PHP_EOL);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        Log::info(__CLASS__ . ' () ' . json_encode('updated') . PHP_EOL);
    }


    /**
     * Handle the Task "deleting" event.
     */
    public function deleting(Task $task): void
    {
        Log::info(__CLASS__ . ' () ' . json_encode('deleting') . PHP_EOL);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        Log::info(__CLASS__ . ' () ' . json_encode('deleted') . PHP_EOL);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
