<?php

namespace App\Http\Resources\Assistant;

use App\Http\Resources\User\PatientConditionDetailsResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssistantPatientDetailsResponse extends JsonResource
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
            'name_medical_condition' => $this->name_medical_condition,
            'description' => $this->description,
            'patient' =>   new PatientConditionDetailsResponse($this->whenLoaded('patientCondition'))

        ];
    }
}
