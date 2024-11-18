<?php

namespace App\Http\Requests\Assistant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssistantInfoRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'phone_number' => 'nullable|string|max:20',

        ];
    }
}
