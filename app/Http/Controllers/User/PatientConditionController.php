<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PatientConditionRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\User\PatientConditionDetailsResponse;
use App\Http\Resources\User\PatientConditionResponse;
use App\Services\PatientConditionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientConditionController extends Controller
{
    private PatientConditionService $patientService;

    public function __construct(PatientConditionService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function addPatientCondition(PatientConditionRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['user_id'] = $user->id;

        $patientCondition = $this->patientService->addPatientCondition($data);

        return ApiResponse::success(new PatientConditionResponse($patientCondition), 200, ' add successfully');
    }

    public function updatePatientCondition(PatientConditionRequest $request)
    {
        $patient_id = $request->input('id');

        $data = $request->all();

        try {
            $conditions = $this->patientService->updatePatientCondition($data, $patient_id);
            return ApiResponse::success(true, 200, 'Patient Condition update successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error($e->getMessage(), 404,404);
        }
    }

    public function getAllPatientCondition()
    {
        $userId = Auth::id();

        $conditions = $this->patientService->getAllPatientCondition($userId);

        return ApiResponse::success(PatientConditionResponse::collection($conditions), 200, 'Successfully');
    }

    public function getPatientDetails(Request $request)
    {
        $patient_id = $request->input('patient_id');

        $result = $this->patientService->getPatientDetails($patient_id);

        if ($result) {
            return ApiResponse::success(new PatientConditionDetailsResponse($result), 200, 'Successfully');
        } else {
            return ApiResponse::error('Patient Condition not found', 404,404);
        }
    }
}
