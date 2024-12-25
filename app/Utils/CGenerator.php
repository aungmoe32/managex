<?php

namespace App\Utils;

use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CGenerator extends DefaultUrlGenerator
{
    public function geturl(): string
    {
        // $url = $this->getdisk()->url($this->getpathrelativetoroot());
        $url = $this->getpathrelativetoroot();
        if ($this->media->collection_name == 'profile') {
            return URL::signedRoute('profile.image', ['id' => $this->media->id, 'filename' => $this->media->file_name]);
            // return $this->versionurl(url("api/profile-image/" . $url));
        }
        return $this->versionurl(url("api/medias/" . $url));
    }
}
