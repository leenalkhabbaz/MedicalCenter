<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResponse extends JsonResource
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
            'description' => $this->description,
            'image' => $this->image,
            'first_dose' => $this->first_dose ? \Carbon\Carbon::parse($this->first_dose)->toISOString() : null,
            'frequent' => $this->frequent,
            'action_date_type' => $this->action_date_type,
            'end_date' => $this->end_date,
            'pills_per_dose' => $this->pills_per_dose,
            'is_continuous' => $this->is_continuous,

        ];
    }
}
