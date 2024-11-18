<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    protected $fillable = [
        'patient_condition_id',
        'type',
        'type_id',
        'reel',
        'thumbnail',
        'is_watched',
        'is_visible',
        'created_at_reel'


    ];
    protected $casts = [
        'is_watched' => 'boolean',
    ];

    public function patientCondition()
    {
        return $this->belongsTo(PatientCondition::class, 'patient_condition_id');
    }
}
