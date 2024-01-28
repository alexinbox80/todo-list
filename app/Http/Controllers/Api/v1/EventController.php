<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreRequest;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use App\Services\Response\ResponseService;
use App\Services\Event\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/v1/event",
     *     operationId="event.store",
     *     tags={"Event"},
     *     description="Создать событие",
     *
     *     @OA\Parameter(
     *          name="task_id",
     *          description="идентификатор задания",
     *          required=true,
     *          in="query",
     *           @OA\Schema(
     *              type="int",
     *          ),
     *      ),
     *
     *     @OA\Parameter(
     *          name="title",
     *          description="название события",
     *          required=true,
     *          in="query",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *
     *     @OA\Parameter(
     *          name="description",
     *          description="описание события",
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
     * @param StoreRequest $request
     * @param ResponseService $responseService
     * @param EventService $eventService
     * @return JsonResponse
     */
    public function store(
        StoreRequest    $request,
        ResponseService $responseService,
        EventService    $eventService,
    ): JsonResponse
    {
        $validated = $request->validated();

        $event = $eventService->store($validated);

        if (!is_null($event))
            return $responseService->success([EventResource::make($event)]);
        else
            return $responseService->unSuccess();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/v1/event/{event_id}",
     *     operationId="event.destroy",
     *     tags={"Event"},
     *     description="Удалить событие по идентификатору",
     *
     *     @OA\Parameter(
     *          name="event_id",
     *          description="идентификатор событие",
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
     * @param Event $event
     * @param ResponseService $responseService
     * @param EventService $eventService
     * @return JsonResponse
     */
    public function destroy(
        Event           $event,
        ResponseService $responseService,
        EventService    $eventService
    ): JsonResponse
    {
        $response = $eventService->destroy($event);

        if ($response)
            return $responseService->success([
                'message' => __('messages.event.destroy.success')
            ]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.event.destroy.failed')
            ]);
    }
}
