<?php

namespace App\Http\Requests;

use App\Enums\TaskCategoryEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => new Enum(TaskStatusEnum::class),
            'due_date' => 'required|date_format:Y-m-d|after:today',
            'categories' => ['required', new Enum(TaskCategoryEnum::class)]
        ];
    }
}
