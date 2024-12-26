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
        return [
            ...parent::toArray($request),
            'image_url' => $this->profile->getFirstMedia('profile')->getUrl(),
            'categories' => CategoryResource::collection($this->categories),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
