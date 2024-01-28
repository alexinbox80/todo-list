<?php

namespace App\Models;

use App\Events\TaskCreatedEvent;
use App\Events\TaskCreatingEvent;
use App\Events\TaskDeletedEvent;
use App\Events\TaskDeletingEvent;
use App\Events\TaskSavedEvent;
use App\Events\TaskSavingEvent;
use App\Events\TaskUpdatedEvent;
use App\Events\TaskUpdatingEvent;
use App\Listeners\CreateTaskCreatedNotification;
use App\Listeners\CreateTaskCreatingNotification;
use App\Listeners\CreateTaskDeletedNotification;
use App\Listeners\CreateTaskDeletingNotification;
use App\Listeners\CreateTaskSavedNotification;
use App\Listeners\CreateTaskSavingNotification;
use App\Listeners\CreateTaskUpdatedNotification;
use App\Listeners\CreateTaskUpdatingNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

/**
 * @OA\Schema(
 *     title="Task",
 *     description="список задач",
 *     @OA\Xml(
 *         name="Task"
 *     )
 * )
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="id",
     *     description="id",
     *     format="int64",
     *     example=1
     * )
     */
    private int $id;

    /**
     * @OA\Property(
     *     title="user_id",
     *     description="идентификатор пользователя",
     *     format="int64",
     *     example=1
     * )
     */
    private int $user_id;

    /**
     * @OA\Property(
     *     title="title",
     *     description="заголовок задачи",
     *     format="title",
     *     example="заголовок"
     * )
     */
    private string $title;

    /**
     * @OA\Property(
     *     title="description",
     *     description="описание задачи",
     *     format="description",
     *     example="описание"
     * )
     */
    private string $description;


    /**
     * @OA\Property(
     *     title="status",
     *     description="статус задачи",
     *     format="status",
     *     example="enam('active', 'done', 'remove')"
     * )
     */
    private string $status;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status'
    ];
    /**
     * Регистрация любых событий вашего приложения.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        Event::listen(
            TaskCreatedEvent::class,
            [CreateTaskCreatedNotification::class, 'handle']);

        Event::listen(
            TaskCreatingEvent::class,
            [CreateTaskCreatingNotification::class, 'handle']);

        Event::listen(
            TaskSavingEvent::class,
            [CreateTaskSavingNotification::class, 'handle']);

        Event::listen(
            TaskSavedEvent::class,
            [CreateTaskSavedNotification::class, 'handle']);

        Event::listen(
            TaskUpdatedEvent::class,
            [CreateTaskUpdatedNotification::class, 'handle']);

        Event::listen(
            TaskUpdatingEvent::class,
            [CreateTaskUpdatingNotification::class, 'handle']);

        Event::listen(
            TaskDeletedEvent::class,
            [CreateTaskDeletedNotification::class, 'handle']);

        Event::listen(
            TaskDeletingEvent::class,
            [CreateTaskDeletingNotification::class, 'handle']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
