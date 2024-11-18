<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResponse extends JsonResource
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
            'user_name' => $this->user_name,
            'phone' => $this->phone,
            'secondary_phone' => $this->secondary_phone,
            'fcm_token' => $this->fcm_token,
            'user_setting' => [
                'language' => $this->language ?? "ar",
            ],

        ];
    }
}
