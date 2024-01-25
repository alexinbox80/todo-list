<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
