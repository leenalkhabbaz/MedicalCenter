<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_name' => 'required|string|exists:users',
            'password' => 'required|string|min:6',
            'fcm_token' => 'nullable|string',

        ];
    }


}
