<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'user' => !is_null($this->user) ? new UserResource($this->user) : null,
            'title' => $this->title,
            'description' => !is_null($this->description) ? $this->description : null,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
