<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'assistant_id',
        'is_notifications',
        'is_reminder',
        'reminder_medicine_time',
        'reminder_medicine_type',
        'reminder_session_time',
        'reminder_session_type',
        'reminder_activity_time',
        'reminder_activity_type'
    ];
    protected $casts = [
        'is_reminder' => 'boolean',
        'is_notifications' => 'boolean',

    ];

}
