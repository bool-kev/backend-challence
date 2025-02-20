<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateBlogRequest extends FormRequest
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
        return [
            'titre' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'content' => ['sometimes', 'string'],
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'slug' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string'],
            'themes' => ['sometimes', 'string'],
            'published_at' => ['sometimes', 'date', 'nullable', 'after_or_equal:today'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->titre)
        ]);
    }
}
