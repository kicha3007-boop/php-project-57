<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LabelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', Rule::unique('labels')->ignore($this->route('label'))],
            'description' => ['nullable', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return ['name.unique' => __('labels.unique')];
    }
}
