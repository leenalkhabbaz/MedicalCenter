<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'assistant_id' => 'nullable|exists:assistants,id',
            'is_notifications' => 'in:true,false',
            'is_reminder' => 'in:true,false',
            'reminder_medicine_time' => 'numeric',
            'reminder_medicine_type' => 'string|in:hour,day,minute',
            'reminder_session_time' => 'numeric',
            'reminder_session_type' => 'string|in:hour,day,minute',
            'reminder_activity_time' => 'numeric',
            'reminder_activity_type' => 'string|in:hour,day,minute',
        ];
    }
}
