<?php

namespace App\Repositories\Interfaces;


interface HomeRepositryInterface
{
    public function getDailyTasks( $patientConditionId,  $date);

}
