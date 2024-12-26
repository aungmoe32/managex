<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use App\Validation\ValidateMediaSize;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string',
            'body' => 'required|string',
            'publish' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id',
            'user_id' => 'sometimes|integer|exists:users,id',
            'medias' => 'sometimes|array',
            'medias.*' => 'sometimes|file',
            // 'medias.*' => 'required|file|mimes:jpeg,png,mp4|max:2048', // Validate each file
        ];
    }

    public function after(): array
    {
        return [
            new ValidateMediaSize
        ];
    }
}
