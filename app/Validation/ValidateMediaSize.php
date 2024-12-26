<?php

namespace App\Validation;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class ValidateMediaSize
{
    // validate image and video size
    function __invoke(Validator $validator)
    {
        if ($validator->errors()->any()) return;
        if (!request()->hasFile('medias')) return;

        foreach (request()->file('medias') as $file) {
            $mimeType = $file->getMimeType();

            if (str_starts_with($mimeType, 'image/')) {
                // Images: Max size 5MB
                if ($file->getSize() > 5 * 1024 * 1024) {
                    $validator->errors()->add('medias', 'Each image must not exceed 5MB.');
                }
            } elseif (str_starts_with($mimeType, 'video/')) {
                // Videos: Max size 50MB
                if ($file->getSize() > 50 * 1024 * 1024) {
                    $validator->errors()->add('medias', 'Each video must not exceed 50MB.');
                }
            } elseif (str_starts_with($mimeType, 'application/pdf')) {
                // Pdf: Max size 50MB
                if ($file->getSize() > 50 * 1024 * 1024) {
                    $validator->errors()->add('medias', 'Each pdf must not exceed 50MB.');
                }
            } else {
                // Invalid file type
                $validator->errors()->add('medias', 'Unsupported file type uploaded.');
            }
        }
    }
}
