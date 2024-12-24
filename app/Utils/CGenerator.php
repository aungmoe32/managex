<?php

namespace App\Utils;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CGenerator extends DefaultUrlGenerator
{
    public function geturl(): string
    {
        // $url = $this->getdisk()->url($this->getpathrelativetoroot());
        $url = $this->getpathrelativetoroot();
        if ($this->media->collection_name == 'profile') {
            return $this->versionurl(url("api/profile-image/" . $url));
        }
        return $this->versionurl(url("api/medias/" . $url));
    }
}
