<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $profileMedia = $this->profile->getFirstMedia('profile');
        return [
            ...parent::toArray($request),
            'image_url' => $this->profile->getImageUrl(),
            'categories' => CategoryResource::collection($this->categories),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'favourites' => PostResource::collection($this->whenLoaded('favourites'))
        ];
    }
}
