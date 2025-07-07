<?php

namespace App\Utils;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CGenerator extends DefaultUrlGenerator
{
    public function geturl(): string
    {
        $url = $this->getpathrelativetoroot(); // {id}/{filename}

        return Storage::disk('s3')->temporaryUrl(
            $url,
            now()->addMinutes(30)
        );
    }
}
