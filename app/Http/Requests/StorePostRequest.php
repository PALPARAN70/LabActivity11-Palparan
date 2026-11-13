<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->author !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:120'],
            'body'         => ['required', 'string', 'min:20'],
            'category'     => ['required', Rule::in(['Announcement', 'Health', 'Peace & Order', 'Ayuda', 'Lost & Found'])],
            'tags'         => ['required', 'array', 'min:1'],
            'tags.*'       => ['exists:tags,id'],
            'is_published' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'tags.required' => 'Pick at least one tag.',
        ];
    }
}