<?php

namespace App\Repositories;

use App\Models\Activities;
use App\Models\CureSession;
use App\Models\medicine;
use App\Repositories\Interfaces\HomeRepositryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class HomeRepositry implements HomeRepositryInterface
{

    public function getDailyTasks($patientConditionId, $date)
    {
        $date = Carbon::parse($date)->startOfDay();

        $medicines = medicine::where('patient_condition_id', $patientConditionId)
            ->where(function ($query) use ($date) {
                $query->whereDate('first_dose', '<=', $date)
                    ->whereDate('end_date', '>=', $date)
                    ->where(function ($query) use ($date) {
                        $query->where(function ($q) use ($date) {
                            $q->where('action_date_type', 'day')
                                ->whereRaw("MOD(DATEDIFF(?, first_dose), frequent) = 0", [$date]);
                        })->orWhere(function ($q) use ($date) {
                            $q->where('action_date_type', 'hour')
                                ->whereRaw("TIMESTAMPDIFF(HOUR, first_dose, ?) % frequent = 0", [$date]);
                        })->orWhere(function ($q) use ($date) {
                            $q->where('action_date_type', 'week')
                                ->whereRaw("MOD(TIMESTAMPDIFF(WEEK, first_dose, ?), frequent) = 0", [$date]);
                        })->orWhere(function ($q) use ($date) {
                            $q->where('action_date_type', 'month')
                                ->whereRaw("MOD(TIMESTAMPDIFF(MONTH, first_dose, ?), frequent) = 0", [$date]);
                        });
                    });
            })
            ->get();



        return [
            'medicines' => $medicines,

        ];
    }


}
