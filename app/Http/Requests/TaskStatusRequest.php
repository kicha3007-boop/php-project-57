<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', Rule::unique('task_statuses')->ignore($this->route('task_status'))],
        ];
    }

    public function messages(): array
    {
        return ['name.unique' => __('task_statuses.unique')];
    }
}
