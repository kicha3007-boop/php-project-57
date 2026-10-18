<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', Rule::unique('tasks')->ignore($this->route('task'))],
            'description' => ['nullable', 'max:5000'],
            'status_id' => ['required', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'exists:users,id'],
            'labels' => ['nullable', 'array'],
            'labels.*' => ['exists:labels,id'],
        ];
    }

    public function messages(): array
    {
        return ['name.unique' => __('tasks.unique')];
    }
}
