<?php

namespace App\Services\Task;

use App\Models\Event;
use App\Models\Task;
use App\Enums\TaskStatus;
use App\Enums\TypeEvent;
use App\Events\TaskCreatedEvent;
use App\Events\TaskCreatingEvent;
use App\Events\TaskDeletedEvent;
use App\Events\TaskDeletingEvent;
use App\Events\TaskUpdatedEvent;
use App\Events\TaskUpdatingEvent;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * @param string|null $status
     * @return array
     */
    public function index(string $status = null): array
    {
        $userId = Auth::user()->id;

        $messages = Task::query();
        $messages->where('user_id', $userId);

        if ($status === TaskStatus::ACTIVE->value) {
            $messages->where('status', TaskStatus::ACTIVE->value);
        }

        if ($status === TaskStatus::REMOVE->value) {
            $messages->where('status', TaskStatus::REMOVE->value);
        }

        if ($status === TaskStatus::DONE->value) {
            $messages->where('status', TaskStatus::DONE->value);
        }

        $messages->with(['user']);

        return [
            'data' => $messages->latest('created_at')->paginate(config('pagination.index.tasks'))
        ];
    }

    /**
     * @param array $validated
     * @return Task
     */
    public function store(array $validated): Task
    {
        if (Event::propertyIsSet(TypeEvent::CREATING->value)) {
            event(new TaskCreatingEvent);
        }

        $validated['user_id'] = Auth::user()->id;

        $task = Task::create(
            $validated
        );

        if (Event::propertyIsSet(TypeEvent::CREATED->value)) {
            event(new TaskCreatedEvent);
        }

        return $task->refresh();
    }

    /**
     * @param Task $task
     * @return array|null
     */
    public function show(Task $task): array|null
    {
        $userId = Auth::id();

        if ($task->user_id === $userId)
            return [
                'data' => $task
            ];
        else
            return null;
    }

    /**
     * @param Task $task
     * @param array $validated
     * @return array|null
     */
    public function update(Task $task, array $validated): array|null
    {
        if (Event::propertyIsSet(TypeEvent::UPDATING->value)) {
            event(new TaskUpdatingEvent);
        }

        $userId = Auth::id();

        if ($task->user_id === $userId) {
            $task->update($validated);

            if (Event::propertyIsSet(TypeEvent::UPDATED->value)) {
                event(new TaskUpdatedEvent);
            }

            return [
                'data' => $task->refresh()
            ];
        } else
            return null;
    }

    /**
     * @param Task $task
     * @return bool|null
     */
    public function destroy(Task $task): bool|null
    {
        if (Event::propertyIsSet(TypeEvent::DELETING->value)) {
            event(new TaskDeletingEvent);
        }

        $userId = Auth::id();
        if ($task->user_id === $userId) {
            if (Event::propertyIsSet(TypeEvent::DELETED->value)) {
                event(new TaskDeletedEvent);
            }

            return $task->delete();
        } else
            return null;
    }
}
