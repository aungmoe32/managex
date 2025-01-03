<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $profileMedia = $this->profile->getFirstMedia('profile');
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'email' => $this->email,
            'profile' => $this->whenLoaded('profile'),
            'image_url' => $profileMedia ? $profileMedia->getUrl() : asset('/images/profile.png'),
            'interested_categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
