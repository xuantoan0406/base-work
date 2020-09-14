<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationRequest
{
    public function messages()
    {
        return [
            'required' => ':attribute.required',
            'regex' => ':attribute.invalid_format',
            'max' => ':attribute.max',
            'string' => ':attribute.string',
            'image' => ':attribute.image'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json(['success' => false, 'error' => $validator->errors()]));
    }

}
