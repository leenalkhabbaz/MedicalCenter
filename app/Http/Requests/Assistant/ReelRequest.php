<?php

namespace App\Http\Requests\Assistant;

use Illuminate\Foundation\Http\FormRequest;

class ReelRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'patient_condition_id' => 'integer|exists:patient_conditions,id',
            'type_id' => 'required|integer',
            'type' => 'required|string|in:hour,medicine,session,activity',
            'reel' => 'required|file|mimes:mp4,mov,avi,flv|max:200000',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
        ];
    }
}
