<?php

namespace App\Http\Requests;

use App\Traits\ValidationRequest;
use App\Http\Resources\StatusResource;
use App\Utils\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AddStatusRequest extends FormRequest
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
            "status" => 'string|required|max:150',
            "color" => 'string|required|regex:/^#([0-9A-F]{3}){1,2}$/i',
        ];
    }


}
