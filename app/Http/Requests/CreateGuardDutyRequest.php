<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateGuardDutyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'emirates_id'       => 'required',
            'guard'             => 'required',
            'company'           => 'required',
            'time_policy'       => 'required',
            'date_joining'      => 'required',
            'duty_start_time'   => 'required',
            'key'               => 'nullable',
            'wireless'          => 'nullable',
            'uniform'           => 'nullable',
            'shoes'             => 'nullable',
            'weapan'            => 'nullable',
            'others'            => 'nullable',
            'file'              => 'required',
            'notes'             => 'nullable',
            'guard_id'          => 'nullable',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Custom response or throw an exception
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
