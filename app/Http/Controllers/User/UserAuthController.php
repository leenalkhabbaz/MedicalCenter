<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\UpdateUserInfoRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\User\UserResponse;
use App\Models\User;
use App\Services\PatientConditionService;
use App\Services\UserAuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService ,PatientConditionService $pService)
    {
        $this->userAuthService = $userAuthService;
    }



    public function register(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();

            // Register the user using the service
            $user = $this->userAuthService->register($data);

            if (!$user) {
                return ApiResponse::error('User registration failed', 500);
            }

            // Login after registration
            $token = $this->userAuthService->login([
                'user_name' => $request->user_name,
                'password' => $request->password,
            ]);

            if (!$token) {
                return ApiResponse::error('Invalid user_name or password', 401);
            }

            // Successful registration and login response
            return ApiResponse::success(
                array_merge(
                    (new UserResponse($user))->toArray(request()),
                    ['access_token' => $token]
                ),
                200,
                'Successfully SignUp'
            );
        } catch (\Exception $e) {
            // Check if the exception message is due to duplicate user_name
            if ($e->getMessage() == 'The user_name has already been taken.') {
                return ApiResponse::error('The user_name is already in use, please choose another one.', 409,409);
            }

            return ApiResponse::error($e->getMessage(), 400,400);
        }
    }


    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('user_name', 'password');
        $fcmToken = $request->input('fcm_token');
        try {
            $result = $this->userAuthService->login($credentials);

            if (!$result) {
                return ApiResponse::error('Invalid user_name or password', 401,401);
            }

            $user = User::where('user_name', $credentials['user_name'])->first();

            $user->update([
                'fcm_token' => $fcmToken
            ]);

            return ApiResponse::success(
                array_merge(
                    (new UserResponse($user))->toArray($request),
                    ['access_token' => $result]
                ),
                200,
                'Successfully logged in'
            );
        }  catch (ModelNotFoundException $e)  {
            return ApiResponse::error($e->getMessage(), 402,402);
        }


    }
    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('User not authenticated', 401,401);
        }

        $user->tokens()->delete();

        return ApiResponse::success(true, 200, 'Successfully logged out');
    }


}
