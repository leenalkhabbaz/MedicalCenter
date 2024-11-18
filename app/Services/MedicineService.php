<?php

namespace App\Services;

use App\Repositories\Interfaces\MedicineRepositoryInterface;

class MedicineService
{
    private MedicineRepositoryInterface $medicineRepository;

    public function __construct(MedicineRepositoryInterface $medicineRepository)
    {
        $this->medicineRepository = $medicineRepository;
    }

    public function addNewMedicines(array $data): array
    {
        foreach ($data['medicines'] as &$medicine) {
            $medicine['is_continuous'] = filter_var($medicine['is_continuous'], FILTER_VALIDATE_BOOLEAN);

            if (isset($medicine['first_dose'])) {
                $medicine['first_dose'] = \Carbon\Carbon::parse($medicine['first_dose'])->format('Y-m-d H:i:s');
            }

        }
        return $this->medicineRepository->addNewMedicines($data);
    }

    public function updateMedicine(array $data, $medicineId)
    {
        if (isset($data['is_continuous'])) {
            $data['is_continuous'] = filter_var($data['is_continuous'], FILTER_VALIDATE_BOOLEAN);
        }
        if (isset($data['first_dose'])) {
            $data['first_dose'] = \Carbon\Carbon::parse($data['first_dose'])->format('Y-m-d H:i:s');
        }

        return $this->medicineRepository->updateMedicine($data, $medicineId);
    }

    public function deleteMedicine($medicineId)
    {
        return $this->medicineRepository->deleteMedicine($medicineId);

    }


}
