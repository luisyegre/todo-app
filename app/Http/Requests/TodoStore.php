<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TodoStore extends FormRequest
{

    public function rules(): array
    {
        return [
            "title"=>"required",
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'error'     => $validator->errors()
        ],400));
    }

    public function messages()
    {
        return [
            "title.required"=>"The title is required",
        ];
    }
}
