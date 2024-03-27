<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateGuardRequest extends FormRequest
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
            // 'name' => 'required|string',
            // 'phone_number' => 'required',
            // 'date' => 'nullable',
            // 'company' => 'required',
            // 'country' => 'required',
            // 'photo' => 'nullable',
            // 'passport' => 'nullable',
            // 'emirates_id_number' => 'required',
            // 'emirates_id_photo' => 'required',
            // 'resume' => 'required',
            // 'acount_holder_name' => 'required',
            // 'acount_number' => 'required',
            // 'bank_name' => 'required',
            // 'branch_name' => 'required',
            // 'location' => 'nullable',
            // 'tax_payer_id' => 'nullable',
            // 'user_id' => 'nullable',
            // 'company_id' => 'nullable'

            'name'               => 'nullable|string',
            'phone_number'       => 'nullable',
            'date'               => 'nullable',
            'company'            => 'nullable',
            'country'            => 'nullable',
            'photo'              => 'nullable',
            'passport'           => 'nullable',
            'emirates_id_number' => 'nullable',
            'emirates_id_photo'  => 'nullable',
            'resume'             => 'nullable',
            'acount_holder_name' => 'nullable',
            'acount_number'      => 'nullable',
            'bank_name'          => 'nullable',
            'branch_name'        => 'nullable',
            'location'           => 'nullable',
            'tax_payer_id'       => 'nullable',
            'user_id'            => 'nullable',
            'company_id'         => 'nullable',

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
