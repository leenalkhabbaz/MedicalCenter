<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assistant\AssistantRegisterRequest;
use App\Http\Requests\Assistant\UpdateAssistantInfoRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\Assistant\AssistantResponse;
use App\Http\Resources\UserResponse;
use App\Models\Assistant;
use App\Services\AssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    private AssistantService $assistantService;

    public function __construct(AssistantService $assistantService)
    {
        $this->assistantService = $assistantService;
    }

    public function register(AssistantRegisterRequest $request)
    {

        $data = $request->validated();

        $assistant = $this->assistantService->register($data);

        if (!$assistant) {
            return ApiResponse::error('User registration failed', 500,500);
        }

        $token = $assistant->createToken('AssistantToken')->plainTextToken;

        return ApiResponse::success(
            array_merge(
                (new AssistantResponse($assistant))->toArray(request()),
                ['access_token' => $token]
            ),
            200,
            'Successfully SignUp'
        );
    }

    public function updateAssistantInfo(UpdateAssistantInfoRequest $request)
    {
        $assistant = Auth::guard('assistant')->user();
        if (!$assistant) {
            return ApiResponse::error('Assistant not found', 404,404);
        }
        $data = $request->validated();

        $updated = $this->assistantService->updateAssistantInfo($assistant, $data);

        if (!$updated) {
            return ApiResponse::error('Unable to update assistant info', 500,500);
        }

        return ApiResponse::success(new AssistantResponse($assistant), 200, 'Assistant info updated successfully');
    }



}
