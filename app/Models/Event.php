<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     *     title="title",
     *     description="событие",
     *     format="title",
     *     example="task.updated"
     * )
     */
    private string $title;

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
        'title',
        'description'
    ];
}
