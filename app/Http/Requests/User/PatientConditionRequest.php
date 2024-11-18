<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PatientConditionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string',
           'can_update' => 'nullable|boolean'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'The name field is required.',
    //         'relationship.required' => 'The relationship field is required.',
    //         'address.required' => 'The address field is required.',
    //         'description.required' => 'The description field is required.',
    //     ];
    // }
}
