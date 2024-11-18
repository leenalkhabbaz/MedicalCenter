<?php

namespace App\Services;

use App\Models\PatientCondition;
use App\Repositories\Interfaces\PatientConditionRepositryInterface;

class PatientConditionService
{
    private PatientConditionRepositryInterface $patientRepository;

    public function __construct(PatientConditionRepositryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function addPatientCondition(array $data): PatientCondition
    {
        do {
            $data['code'] = mt_rand(1000000, 9999999);
        } while (PatientCondition::where('code', $data['code'])->exists());

        if (isset($data['can_update'])) {
            $data['can_update'] = filter_var($data['can_update'], FILTER_VALIDATE_BOOLEAN);
        }

        return $this->patientRepository->addPatientCondition($data);
    }

    public function updatePatientCondition(array $data, $patientId)
    {
        if (isset($data['can_update'])) {
            if (is_bool($data['can_update'])) {
                $data['can_update'] = $data['can_update'];
            } elseif (is_string($data['can_update'])) {
                $data['can_update'] = in_array($data['can_update'], ['true', '1'], true);
            }
        }

        return $this->patientRepository->updatePatientCondition($data, $patientId);
    }

    public function getAllPatientCondition($userId)
    {
        return $this->patientRepository->getAllPatientCondition($userId);
    }

    public function getPatientDetails($patientId)
    {
        return $this->patientRepository->getPatientDetails($patientId);
    }


}
