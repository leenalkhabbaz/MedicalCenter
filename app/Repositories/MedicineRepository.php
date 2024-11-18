<?php

namespace App\Repositories;

use App\Models\medicine;
use App\Models\PatientCondition;
use App\Repositories\Interfaces\MedicineRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class MedicineRepository implements MedicineRepositoryInterface
{
    public function addNewMedicines(array $data): array
    {
        $medicines = [];

        foreach ($data['medicines'] as $medicineData) {

            if (isset($medicineData['image'])) {
                $imagePath = $medicineData['image']->store('medicines', 'public');
                $medicineData['image'] = $imagePath;
            }

            $medicineData['patient_condition_id'] = $data['patient_condition_id'];

            $medicines[] = medicine::create($medicineData);
        }

        return $medicines;
    }

    public function updateMedicine(array $data, $medicineId)
    {
        $medicine = medicine::find($medicineId);

        if (!$medicine) {
            throw new ModelNotFoundException("medicine not found.");
        }

        if (isset($data['image'])) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }

            $imagePath = $data['image']->store('medicines', 'public');
            $data['image'] = $imagePath;
        }

        $filteredData = array_filter($data, fn($value) => !is_null($value) && $value !== '');
        $medicine->update($filteredData);
    }

    public function deleteMedicine($medicineId)
    {
        $medicine = medicine::find($medicineId);

        if ($medicine) {
            $medicine->delete();
            return true;
        }

        return false;
    }

    public function getAllPatientMedicines($patient_id)
    {
        $medicines = medicine::where('patient_condition_id', $patient_id)
        ->orderByDesc('created_at')
            ->get();
        return $medicines;
    }

    // ************************Assistant******************************//
    public function updateAssistantMedicine(array $data, $medicineId)
    {
        $medicine = medicine::find($medicineId);

        if (!$medicine) {
            throw new ModelNotFoundException("medicine not found.");
        }

        $patientCondition = $medicine->patientCondition;
        if ($patientCondition && !$patientCondition->can_update) {
            throw new \Exception("Assistant is not allowed to update this medicine.");
        }
        $filteredData = array_filter($data, fn($value) => !is_null($value) && $value !== '');
        $medicine->update($filteredData);

        return $medicine;
    }

    public function addAssistantMedicines(array $data): array
    {
        $medicines = [];

        foreach ($data['medicines'] as $medicineData) {
            $medicineData['patient_condition_id'] = $data['patient_condition_id'];

            $patientCondition = PatientCondition::find($medicineData['patient_condition_id']);

            if ($patientCondition && $patientCondition->can_update == 1) {
                $medicines[] = medicine::create($medicineData);
            } else {
                throw new \Exception("Adding medicine is not allowed for this patient condition.");
            }
        }

        return $medicines;
    }
}
