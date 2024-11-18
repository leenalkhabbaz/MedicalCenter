<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    protected $fillable = [
        'patient_condition_id',
        'name',
        'image',
        'description',
        'pills_per_dose',
        'first_dose',
        'frequent',
        'action_date_type',
        'end_date',
        'is_continuous',

    ];
    protected $casts = [
        'is_continuous' => 'boolean',
    ];

    public function patientCondition()
    {
        return $this->belongsTo(PatientCondition::class, 'patient_condition_id');
    }
}
