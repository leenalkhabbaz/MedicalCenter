<?php

namespace App\Repositories;

use App\Models\AssistantPatientCondition;
use App\Models\PatientCondition;
use App\Repositories\Interfaces\PatientConditionRepositryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class PatientConditionRepository implements PatientConditionRepositryInterface
{
    public function addPatientCondition(array $data)
    {
        return PatientCondition::create($data);
    }

    public function updatePatientCondition(array $data, $patientId)
    {
        $patient = PatientCondition::find($patientId);

        if (!$patient) {
            throw new ModelNotFoundException("patientCondition not found.");
        }
        $filteredData = array_filter($data, fn($value) => !is_null($value) && $value !== '');
        $patient->update($filteredData);
    }

    public function getAllPatientCondition($userId)
    {
        $conditions = PatientCondition::where('user_id', $userId)
            ->get();
        return $conditions;
    }

    public function getPatientDetails($patientId)
    {
        $conditions = PatientCondition::where('id', $patientId)
            ->with('cureSessions', 'medicines', 'activities')
            ->first();
        return $conditions;
    }


}
