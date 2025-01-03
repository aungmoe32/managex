<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'subject',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'color' => $this->color,
                'code' => $this->code,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
            'included' => new SemesterResource($this->whenLoaded('semester')),
        ];
    }
}
