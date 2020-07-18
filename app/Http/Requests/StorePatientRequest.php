<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|min:3|max:25',
            'last_name' => 'required|string|min:3|max:25',
            'email' => 'required|email:rfc,dns|unique:patients,email',
            'mobile' => 'required|regex:/^0[0-9]{10}/m',
            'country' => 'required|string|min:3|max:20',
            'birth_date' => 'required|date',
            'gender' => ['required', Rule::in(['male', 'female'])],
            'occupation' => 'required|string|min:3|max:100',
            'paintype_id' => 'required|exists:pain_types,id',
        ];
    }
}
