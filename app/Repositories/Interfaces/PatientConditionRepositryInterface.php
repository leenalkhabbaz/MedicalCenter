<?php

namespace App\Repositories\Interfaces;

use App\Models\PatientCondition;

interface PatientConditionRepositryInterface
{
    public function addPatientCondition(array $data);

    public function updatePatientCondition(array $data , $patientId);

    public function getAllPatientCondition($userId);

    public function getPatientDetails($patientId);


}
