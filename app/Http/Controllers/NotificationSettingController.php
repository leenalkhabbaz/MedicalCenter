<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSettingRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\RingTonesResponse;
use App\Services\NotificationSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationSettingController extends Controller
{
    private NotificationSettingService $settingService;

    public function __construct(NotificationSettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function notificationSettings(NotificationSettingRequest $request)
    {
        $userId = Auth::id();
        $data = $request->all();
        $data['user_id'] = $userId;
        $setting = $this->settingService->notificationSettings($userId, $data);
        return ApiResponse::success(true, 200, 'update settings successfully');
    }

}
