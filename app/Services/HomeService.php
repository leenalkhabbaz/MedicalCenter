<?php

namespace App\Services;

use App\Http\Resources\ActivityResponse;
use App\Http\Resources\CureSessionResponse;
use App\Http\Resources\MedicineResponse;
use App\Models\PatientCondition;
use App\Repositories\Interfaces\HomeRepositryInterface;

class HomeService
{
    private HomeRepositryInterface $homeRepository;

    public function __construct(HomeRepositryInterface $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function getDailyTasks($patientConditionId, $dateTime)
    {
        $data = $this->homeRepository->getDailyTasks($patientConditionId, $dateTime);

        $allEvents = [];

        foreach ($data['medicines'] as $medicine) {
            $allEvents[] = [
                'type' => 'medicine',
                'action' => new MedicineResponse($medicine),
            ];
        }

        // foreach ($data['cure_sessions'] as $cureSession) {
        //     $allEvents[] = [
        //         'type' => 'cure_session',
        //         'action' => new CureSessionResponse($cureSession),
        //     ];
        // }

        // foreach ($data['activities'] as $activity) {
        //     $allEvents[] = [
        //         'type' => 'activity',
        //         'action' => new ActivityResponse($activity),
        //     ];
        // }

        usort($allEvents, function ($a, $b) use ($dateTime) {
            $timeA = strtotime($a['action']->time);
            $timeB = strtotime($b['action']->time);
            return abs($timeA - strtotime($dateTime)) - abs($timeB - strtotime($dateTime));
        });

        return $allEvents;
    }

}
