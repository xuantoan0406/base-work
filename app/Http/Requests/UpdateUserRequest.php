<?php

namespace App\Http\Requests;

use App\Traits\ValidationRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    use ValidationRequest;

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'string|max:150',
            "comment" => 'string|max:150',
            "work_place" => 'string|max:150',
            "industry" => 'string|max:150',
            "avatar" => 'image'
        ];
    }
}
