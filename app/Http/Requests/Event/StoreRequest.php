<?php

namespace App\Http\Requests\Event;

use App\Enums\TypeEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $events = [
            TypeEvent::CREATED->value,
            TypeEvent::CREATING->value,
            TypeEvent::UPDATED->value,
            TypeEvent::UPDATING->value,
            TypeEvent::DELETED->value,
            TypeEvent::DELETING->value
        ];

        return [
            'task_id' => ['required', 'numeric', 'exists:tasks,id'],
            'type_event' => ['required', 'string', Rule::in($events)],
            'description' => ['nullable', 'string']
        ];
    }
}
