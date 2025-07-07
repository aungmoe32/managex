<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $downloads = Redis::get("medias:{$this->id}:downloads");
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'size' => $this->size,
            'mime_type' => $this->mime_type,
            'url' => $this->original_url,
            // 'download_url' => url("/api/download/{$this->id}/{$this->file_name}"),
            'downloads' => $downloads ? (int) $downloads : 0
        ];
    }
}
