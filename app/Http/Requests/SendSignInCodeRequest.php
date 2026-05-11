<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendSignInCodeRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }
}
