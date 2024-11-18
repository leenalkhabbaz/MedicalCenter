<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_condition_id' => 'required|exists:patient_conditions,id',
            'medicines' => 'required|array',
            'medicines.*.name' => 'required|string|max:255',
            'medicines.*.image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'medicines.*.description' => 'required|string|max:255',
            'medicines.*.pills_per_dose' => 'required|numeric',
            'medicines.*.first_dose' => 'required|regex:/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d{3,6})?$/',
            'medicines.*.frequent' => 'required|numeric',
            'medicines.*.action_date_type' => 'required|string|in:hour,day,month,week',
            'medicines.*.end_date' => 'nullable|date',
            'medicines.*.is_continuous' => 'required|in:true,false',
        ];
    }
}
