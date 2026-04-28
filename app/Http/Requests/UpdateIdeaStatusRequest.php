<?php

namespace App\Http\Requests;

use App\Enums\IdeaStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIdeaStatusRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(IdeaStatus::class)],
            'message' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
