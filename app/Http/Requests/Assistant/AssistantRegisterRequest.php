<?php

namespace App\Http\Requests\Assistant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssistantRegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fcm_token' => 'nullable|string',
            'name' => 'nullable|string|max:255',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'data' => $errors
        ], 422));
    }
}
