<?php

namespace App\Utils;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CGenerator extends DefaultUrlGenerator
{
    public function geturl(): string
    {
        $url = $this->getdisk()->url($this->getpathrelativetoroot());

        return $this->versionurl(url("api" . $url));
    }
}
