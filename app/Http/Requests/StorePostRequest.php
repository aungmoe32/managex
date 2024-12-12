<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
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
            'medias' => 'required|array',
            'medias.*' => 'required|file',
            // 'medias.*' => 'required|file|mimes:jpeg,png,mp4|max:2048', // Validate each file
        ];
    }

    public function after(): array
    {
        return [
            // validate image and video size
            function (Validator $validator) {
                foreach (request()->file('medias') as $file) {
                    $mimeType = $file->getMimeType();

                    if (str_starts_with($mimeType, 'image/')) {
                        // Images: Max size 5MB
                        if ($file->getSize() > 5 * 1024 * 1024) {
                            $validator->errors()->add('medias', 'Each image must not exceed 2MB.');
                        }
                    } elseif (str_starts_with($mimeType, 'video/')) {
                        // Videos: Max size 50MB
                        if ($file->getSize() > 50 * 1024 * 1024) {
                            $validator->errors()->add('medias', 'Each video must not exceed 10MB.');
                        }
                    } else {
                        // Invalid file type
                        $validator->errors()->add('medias', 'Unsupported file type uploaded.');
                    }
                }
            }
        ];
    }
}
