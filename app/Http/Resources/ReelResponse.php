<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReelResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reel' => $this->reel,
            'thumbnail' => $this->thumbnail,
            'is_watched' => $this->is_watched,
            'created_at' => $this->created_at,

        ];
    }
}
