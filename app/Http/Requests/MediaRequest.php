<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required",
            "description" => "required",
            "image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "type" => "numeric|required"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(response()->json([
    'errors' => $validator->errors(),
    'status' => true
    ], 422));
    }
}
