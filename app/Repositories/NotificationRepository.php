<?php

namespace App\Repositories;

use App\Models\NotificationSetting;

class NotificationRepository
{
    public function getUserNotificationSettings($userId)
    {
        return NotificationSetting::where('user_id', $userId)->first();
    }
}
