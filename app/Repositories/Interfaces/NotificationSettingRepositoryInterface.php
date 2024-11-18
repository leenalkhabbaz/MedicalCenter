<?php

namespace App\Repositories\Interfaces;

use App\Models\NotificationSetting;

interface NotificationSettingRepositoryInterface
{
    public function notificationSettings(int $userId, array $data);



}
