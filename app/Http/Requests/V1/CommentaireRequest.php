<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentaireRequest extends FormRequest
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
            'contenu' => ['required', 'string'],
            'user_id' => ['required', 'integer','exists:users,id'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' =>$this->userId?? Auth::user()->id,
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'contenu.required' => 'Le contenu est obligatoire.',
            'contenu.string' => 'Le contenu doit être une chaîne de caractères.',
            'user_id.required' => 'L\'identifiant de l\'utilisateur est obligatoire.',
            'user_id.integer' => 'L\'identifiant de l\'utilisateur doit être un entier.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.',
        ];
    }
}
