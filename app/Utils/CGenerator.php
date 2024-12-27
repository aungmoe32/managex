<?php

namespace App\Utils;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CGenerator extends DefaultUrlGenerator
{
    public function geturl(): string
    {
        // $url = $this->getdisk()->url($this->getpathrelativetoroot());
        $url = $this->getpathrelativetoroot(); // {id}/{filename}
        if ($this->media->collection_name == 'profile') {
            return URL::temporarySignedRoute('profile.image',  now()->addMinutes(30), ['id' => $this->media->id, 'filename' => $this->media->file_name]);
            // return $this->versionurl(url("api/profile-image/" . $url));
        }

        return Storage::disk('s3')->temporaryUrl(
            $url,
            now()->addMinutes(30)
        );
        // return URL::temporarySignedRoute('medias', now()->addMinutes(30), ['id' => $this->media->id, 'filename' => $this->media->file_name]);
        // return $this->versionurl(url("api/medias/" . $url));
    }
}
