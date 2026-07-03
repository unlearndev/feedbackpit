<?php

namespace App\Http\Requests;

use App\Models\Reaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReactionRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'emoji' => ['required', 'string', Rule::in(Reaction::EMOJIS)],
        ];
    }
}
