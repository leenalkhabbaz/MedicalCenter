<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'pills_per_dose' => 'nullable|numeric',
            'first_dose' => 'nullable|regex:/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d{3,6})?$/',
            'frequent' => 'nullable|numeric',
            'action_date_type' => 'nullable|string|in:hour,day,month,week',
            'end_date' => 'nullable|date',
            'is_continuous' => 'nullable|in:true,false',

        ];
    }

}
