<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

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

//    protected static function boot(): void
//    {
//        parent::boot();

//        static::creating(function (Task $task) {
//            Log::info(__CLASS__ . '() creating ' . json_encode($task) . PHP_EOL);
//        });
//        static::created(function (Task $task) {
//            Log::info(__CLASS__ . '() created ' . json_encode($task) . PHP_EOL);
//        });
//        static::updating(function (Task $task) {
//            Log::info(__CLASS__ . '() updating ' . json_encode($task) . PHP_EOL);
//        });
//        static::updated(function (Task $task) {
//            Log::info(__CLASS__ . '() updated ' . json_encode($task) . PHP_EOL);
//        });
//        static::deleting(function (Task $task) {
//            Log::info(__CLASS__ . '() deleting ' . json_encode($task) . PHP_EOL);
//        });
//        static::deleted(function (Task $task) {
//            Log::info(__CLASS__ . '() deleted ' . json_encode($task) . PHP_EOL);
//        });

//        Event::listen('task.*', function ($eventName, $data) {
//            Log::info(__CLASS__ . ' () ' . json_encode([$eventName, $data]) . PHP_EOL);
//        });
//    }

    protected static function boot(): void
    {
        parent::boot();

        Event::listen('task.*', function ($eventName, $data) {
            Log::info(__CLASS__ . ' () ' . json_encode([$eventName, $data]) . PHP_EOL);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
