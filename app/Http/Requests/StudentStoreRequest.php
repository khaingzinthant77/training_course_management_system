<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            //
            'name' => 'required',
            // 'nrc_code' => 'required',
            // 'nrc_state' => 'required',
            // 'nrc_status' => 'required',
            // 'nrc' => 'required',
            'father_name' => 'required',
            'phone_1' => 'required',
            'address' => 'required',
        ];
    }
}