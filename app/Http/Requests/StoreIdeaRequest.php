<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * Builds a normalized match key from the title that the rest of
     * the request lifecycle can use for validation purposes.
     */
    protected function prepareForValidation(): void
    {
        $title = $this->input('title');

        if (! is_string($title)) {
            return;
        }

        $key = mb_strtolower($title);
        $key = (string) preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $key);
        $key = (string) preg_replace('/\s+/', ' ', $key);
        $key = trim($key);

        $stopwords = ['the', 'a', 'an', 'is', 'are', 'of', 'to', 'and', 'for', 'in', 'on'];
        $parts = array_filter(explode(' ', $key), fn ($w) => ! in_array($w, $stopwords, true));

        $this->merge(['_match_key' => implode(' ', $parts)]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
        ];
    }
}
