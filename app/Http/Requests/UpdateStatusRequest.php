<?php

namespace App\Http\Requests;

use App\Traits\ValidationRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStatusRequest extends FormRequest
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
            "status" => 'string|max:150',
            "color" => 'string|regex:/^#([0-9A-F]{3}){1,2}$/i',
        ];
    }
}
