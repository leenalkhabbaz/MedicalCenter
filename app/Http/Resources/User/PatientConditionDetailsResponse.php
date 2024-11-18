<?php

namespace App\Http\Resources\User;

use App\Http\Resources\ActivityResponse;
use App\Http\Resources\CureSessionResponse;
use App\Http\Resources\MedicineResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientConditionDetailsResponse extends JsonResource
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
            'name' => $this->name,
            'relationship' => $this->relationship,
            'address' => $this->address,
            'description' => $this->description,
            'can_update' => $this->can_update,
            'code' => $this->code,
            'medicines' =>  MedicineResponse::collection($this->whenLoaded('medicines')),

        ];
    }
}
