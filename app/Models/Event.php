<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     title="Event",
 *     description="События",
 *     @OA\Xml(
 *         name="Event"
 *     )
 * )
 */
class Event extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="id",
     *     description="идентификатор события",
     *     format="int64",
     *     example=1
     * )
     */
    private int $id;

    /**
     * @OA\Property(
     *     title="task_id",
     *     description="идентификатор задания",
     *     format="int64",
     *     example=1
     * )
     */
    private int $task_id;

    /**
     * @OA\Property(
     *     title="type_event",
     *     description="событие",
     *     format="title",
     *     example="updated"
     * )
     */
    private string $type_event;

    /**
     * @OA\Property(
     *     title="description",
     *     description="описание события",
     *     format="description",
     *     example="описание"
     * )
     */
    private string $description;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'type_event',
        'description'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
