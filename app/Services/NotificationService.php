<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\CureSession;
use App\Models\Activities;
use App\Models\PatientCondition;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected $firebaseService;
    protected $notificationRepository;

    public function __construct(FirebaseService $firebaseService, NotificationRepository $notificationRepository)
    {
        $this->firebaseService = $firebaseService;
        $this->notificationRepository = $notificationRepository;
    }

    public function sendDailyNotifications()
    {
        $currentDateTime = Carbon::now();
        Log::info('Current DateTime:', [$currentDateTime]);

        $conditions = PatientCondition::with(['user'])->whereHas('user')->get();


        foreach ($conditions as $condition) {
            $userSettings = $this->notificationRepository->getUserNotificationSettings($condition->user_id);
            Log::info('$condition->user_id:', [$condition->user_id]);

            if (!$userSettings || !$userSettings->is_notifications) {
                continue;
            }

            $this->sendMedicineNotifications($condition, $userSettings, $currentDateTime);
            // $this->sendCureSessionNotifications($condition, $userSettings, $currentDateTime);
            // $this->sendActivityNotifications($condition, $userSettings, $currentDateTime);
        }
    }

    private function sendMedicineNotifications($condition, $settings, $currentDateTime)
    {
        $medicines = Medicine::where('patient_condition_id', $condition->id)->get();
        Log::info('Current medicines:', [$medicines]);

        if (!$condition->user) {
            Log::error("No user found for condition ID: {$condition->id}");
            return;
        }

        if (empty($condition->user->fcm_token)) {
            Log::error("FCM Token is missing for user ID: {$condition->user->id}");
            return;
        }

        Log::info('Condition User:', [$condition->user->toArray()]);

        Log::info(' *****************************************************:');


        foreach ($medicines as $medicine) {
            $reminderTime = $this->calculateReminderTime($medicine->first_dose, $settings->reminder_medicine_time, $settings->reminder_medicine_type);

            Log::info("Checking reminder for medicine {$medicine->name} at {$reminderTime}");

            if ($currentDateTime->greaterThanOrEqualTo($reminderTime) && $currentDateTime->lessThan($medicine->first_dose)) {
                Log::info('Sending notification to:', [$condition->user->fcm_token]);

                $this->firebaseService->sendNotification($condition->user->fcm_token, 'Medicine Reminder', "Time to take your medicine: {$medicine->name}");
            }
        }
    }



    private function calculateReminderTime($eventTime, $reminderTime, $reminderType)
    {
        $time = Carbon::parse($eventTime);

        switch ($reminderType) {
            case 'minute':
                return $time->subMinutes($reminderTime);
            case 'hour':
                return $time->subHours($reminderTime);
            case 'day':
                return $time->subDays($reminderTime);
            default:
                return $time;
        }
    }
}
