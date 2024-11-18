<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Services\HomeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function getDailyTasks(Request $request)
{
    $patientConditionId = $request->input('patient_condition_id');
    $date = $request->input('date');

    $tasks = $this->homeService->getDailyTasks($patientConditionId, $date);

    return ApiResponse::success($tasks, 200, 'Daily tasks fetched successfully');
}


}
