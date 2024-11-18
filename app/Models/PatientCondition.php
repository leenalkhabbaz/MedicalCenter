<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'relationship',
        'description',
        'code',
        'can_update',


    ];
    protected $casts = [
        'can_update' => 'boolean',
    ];

    public function activities()
    {
        return $this->hasMany(Activities::class);
    }

    public function medicines()
    {
        return $this->hasMany(medicine::class);
    }

    public function cureSessions()
    {
        return $this->hasMany(CureSession::class);
    }

    public function reels()
    {
        return $this->hasMany(Reel::class);
    }

    public function assistantPatientConditions()
    {
        return $this->hasMany(AssistantPatientCondition::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
