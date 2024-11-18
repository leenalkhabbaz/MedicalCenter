<?php

namespace App\Repositories;

use App\Models\NotificationSetting;
use App\Models\RingTone;
use App\Repositories\Interfaces\NotificationSettingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class NotificationSettingRepository implements NotificationSettingRepositoryInterface
{

    public function notificationSettings(int $userId, array $data)
    {
        return NotificationSetting::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }

}
