<?php

namespace App\Repositories\Interfaces;

use App\Models\Assistant;
use App\Models\medicine;
use App\Models\Supervisor;
use App\Models\User;

interface MedicineRepositoryInterface
{
    public function addNewMedicines(array $data): array;
    public function updateMedicine(array $data , $medicineId);
    public function deleteMedicine($medicineId);



}
