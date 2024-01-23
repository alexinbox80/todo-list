<?php

namespace App\Services\Contracts;

use App\Models\Task;

interface TaskContract
{
    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param array $validated
     * @return Task
     */
    public function store(array $validated): Task;

    /**
     * @param array $validated
     * @return Task|null
     */
    public function update(array $validated): Task|null;
}
