<?php

namespace App\Services\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * @param string $status
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
        $validated['user_id'] = Auth::user()->id;

        $task = Task::create(
            $validated
        );

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
        $userId = Auth::id();

        if ($task->user_id === $userId) {
            $task->update($validated);
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
        $userId = Auth::id();
        if ($task->user_id === $userId)
            return $task->delete();
        else
            return null;
    }
}
