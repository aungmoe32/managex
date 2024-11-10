<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'semester',
            'id' => $this->id,
            'attributes' => [
                'major' => $this->major,
                'year' => $this->year,
                'term' => $this->term,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
        ];
    }
}
