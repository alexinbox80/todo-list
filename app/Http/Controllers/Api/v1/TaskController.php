<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StatusRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Services\Response\ResponseService;
use App\Services\Task\TaskService;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/v1/tasks",
     *     operationId="tasks.index",
     *     tags={"Task"},
     *     description="Получение списка всех задач, принадлежащих пользователю",
     *
     *     @OA\Parameter(
     *          name="status",
     *          description="статус беседы",
     *          required=false,
     *          in="path",
     *           @OA\Schema(
     *              type="string",
     *              example="active, done, remove",
     *          ),
     *      ),
     *
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *     ),
     * )
     *
     * @param ResponseService $responseService
     * @param TaskService $taskService
     * @param StatusRequest $request
     * @return JsonResponse
     */
    public function index(
        ResponseService $responseService,
        TaskService     $taskService,
        StatusRequest   $request
    ): JsonResponse
    {
        $validated = $request->validated();

        if (isset($validated['status']))
            $tasks = $taskService->index($validated['status']);
        else
            $tasks = $taskService->index();

        return $responseService->success([
            TaskResource::collection($tasks['data'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/v1/tasks",
     *     operationId="tasks.store",
     *     tags={"Task"},
     *     description="Создать задание",
     *
     *     @OA\Parameter(
     *          name="title",
     *          description="название задания",
     *          required=true,
     *          in="query",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *
     *     @OA\Parameter(
     *          name="description",
     *          description="описание задания",
     *          required=false,
     *          in="query",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     * )
     *
     * @param ResponseService $responseService
     * @param TaskService $taskService
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(
        ResponseService $responseService,
        TaskService     $taskService,
        StoreRequest    $request
    ): JsonResponse
    {
        $task = $taskService->store($request->validated());
        event('task.creating', [$task]);

        return $responseService->success([
            TaskResource::make($task)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/v1/tasks/{task_id}",
     *     operationId="tasks.show",
     *     tags={"Task"},
     *     description="Показать задание по идентификатору",
     *
     *     @OA\Parameter(
     *          name="task_id",
     *          description="идентификатор задания",
     *          required=true,
     *          in="path",
     *           @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     * )
     *
     * @param Task $task
     * @param ResponseService $responseService
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function show(
        Task            $task,
        ResponseService $responseService,
        TaskService     $taskService
    ): JsonResponse
    {
        $task = $taskService->show($task);

        if (!is_null($task))
            return $responseService->success([TaskResource::make($task['data'])]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.task.show.failed')
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/v1/tasks/{task_id}",
     *     operationId="tasks.update",
     *     tags={"Task"},
     *     description="Обновить поля задания по идентификатору",
     *
     *     @OA\Parameter(
     *          name="task_id",
     *          description="идентификатор задания",
     *          required=true,
     *          in="path",
     *           @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *
     *     @OA\Parameter(
     *          name="title",
     *          description="заголовок задания",
     *          required=false,
     *          in="path",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *
     *     @OA\Parameter(
     *          name="description",
     *          description="описание задания",
     *          required=false,
     *          in="path",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *
     *     @OA\Parameter(
     *          name="status",
     *          description="статус задания",
     *          required=true,
     *          in="path",
     *           @OA\Schema(
     *              type="['active', 'done', 'remove']",
     *          ),
     *      ),
     *
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     * )
     *
     * @param Task $task
     * @param UpdateRequest $request
     * @param ResponseService $responseService
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function update(
        Task            $task,
        UpdateRequest   $request,
        ResponseService $responseService,
        TaskService     $taskService
    ): JsonResponse
    {
        $validated = $request->validated();

        $task = $taskService->update($task, $validated);

        event('task.updating', [$task]);

        if (!is_null($task))
            return $responseService->success([TaskResource::make($task['data'])]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.task.update.failed')
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/v1/tasks/{task_id}",
     *     operationId="tasks.destroy",
     *     tags={"Task"},
     *     description="Удалить задание по идентификатору",
     *
     *     @OA\Parameter(
     *          name="task_id",
     *          description="идентификатор задания",
     *          required=true,
     *          in="path",
     *           @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     * )
     *
     * @param Task $task
     * @param ResponseService $responseService
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function destroy(
        Task            $task,
        ResponseService $responseService,
        TaskService     $taskService
    ): JsonResponse
    {
        $response = $taskService->destroy($task);

        event('task.deleting', [$task]);

        if ($response)
            return $responseService->success([
                'message' => __('messages.task.destroy.success')
            ]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.task.destroy.failed')
            ]);
    }
}
