<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assistant\UpdateAssMedicineRequest;
use App\Http\Requests\MedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\MedicineResponse;
use App\Services\MedicineService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    private MedicineService $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    public function addMedicines(MedicineRequest $request)
    {

        $patient_condition_id = $request->input('patient_condition_id');

        $data = $request->all();
        $data['patient_condition_id'] = $patient_condition_id;

        $medicines = $this->medicineService->addNewMedicines($data);

        return ApiResponse::success(true, 200, 'Medicines added successfully');
    }

    public function updateMedicine(UpdateMedicineRequest $request)
    {
        $medicine_id = $request->input('medicine_id');

        $data = $request->all();

        try {
            $medicines = $this->medicineService->updateMedicine($data, $medicine_id);
            return ApiResponse::success(true, 200, 'Medicines update successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error($e->getMessage(), 404,404);
        }
    }

    public function deleteMedicine(Request $request)
    {
        $medicineId = $request->input('medicineId');

        $result = $this->medicineService->deleteMedicine($medicineId);

        if ($result) {
            return ApiResponse::success(true, 200, 'medicine deleted successfully');
        } else {
            return ApiResponse::error('medicine not found', 404,404);
        }
    }

    public function getAllPatientMedicines(Request $request)
    {
        $patient_id = $request->input('patient_id');

        $result = $this->medicineService->getAllPatientMedicines($patient_id);

        if ($result) {
            return ApiResponse::success(MedicineResponse::collection($result), 200, 'successfully');
        } else {
            return ApiResponse::error('not found', 404,404);
        }
    }


    // **************************Assistant*****************************************///
    public function updateAssistantMedicine(UpdateMedicineRequest $request)
    {
        $assistant = Auth::guard('assistant')->user();
        if (!$assistant) {
            return ApiResponse::error('Assistant not found', 404,404);
        }
        $medicine_id = $request->input('medicine_id');
        $data = $request->all();

        try {
            $this->medicineService->updateAssistantMedicine($data, $medicine_id);
            return ApiResponse::success(true, 200, 'Medicine updated successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('Medicine not found', 404,404);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 403,403);
        }
    }

    public function addAssistantMedicines(MedicineRequest $request)
    {
        $assistant = Auth::guard('assistant')->user();
        if (!$assistant) {
            return ApiResponse::error('Assistant not found', 404,404);
        }

        $patient_condition_id = $request->input('patient_condition_id');

        $data = $request->all();
        $data['patient_condition_id'] = $patient_condition_id;
        try {
            $medicines = $this->medicineService->addAssistantMedicines($data);
            return ApiResponse::success(true, 200, 'Medicines added successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 403,403);
        }
    }
}
