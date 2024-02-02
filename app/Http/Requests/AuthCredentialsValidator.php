<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthCredentialsValidator extends FormRequest
{
    public function rules(): array
    {
        return [
            "email"=>"required|email",
            "password"=>"required|min:6"
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'error'     => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            "email.required"=>"The email is required",
            "email.email"=>"The email most be valid",
            "password.required"=>"The password is required",
        ];
    }
}
