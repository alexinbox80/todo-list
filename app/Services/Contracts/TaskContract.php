<?php

namespace App\Services\Contracts;

use App\Models\Task;

interface TaskContract
{
    /**
     * @param string|null $status
     * @return array
     */
    public function index(string $status = null): array;

    /**
     * @param array $validated
     * @return Task
     */
    public function store(array $validated): Task;

    /**
     * @param Task $task
     * @return array|null
     */
    public function show(Task $task): array|null;

    /**
     * @param Task $task
     * @param array $validated
     * @return array|null
     */
    public function update(Task $task, array $validated): array|null;

    /**
     * @param Task $task
     * @return bool|null
     */
    public function destroy(Task $task): bool|null;
}
