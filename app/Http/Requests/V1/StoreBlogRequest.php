<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'slug' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string'],
            'themes' => ['required', 'string'],
            'published_at' => ['date', 'nullable','after_or_equal:today'],
        ];
    }
}
