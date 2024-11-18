<?php

namespace App\Services;

use App\Models\NotificationSetting;
use App\Repositories\Interfaces\NotificationSettingRepositoryInterface;

class NotificationSettingService
{
    private NotificationSettingRepositoryInterface $settingRepository;

    public function __construct(NotificationSettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function notificationSettings(int $userId, array $data)
    {

        if (isset($data['is_reminder'])) {
            $data['is_reminder'] = filter_var($data['is_reminder'], FILTER_VALIDATE_BOOLEAN);
        }

        if (isset($data['is_notifications'])) {
            $data['is_notifications'] = filter_var($data['is_notifications'], FILTER_VALIDATE_BOOLEAN);
        }

        return $this->settingRepository->notificationSettings($userId,$data);
    }


}
