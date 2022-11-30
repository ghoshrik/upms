<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Designation extends FormRequest
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
            'designation_name' => 'required|string|unique:designations,designation_name|max:255'
        ];
    }
    public function messages()
    {
        return [
            'designation_name.required'=>'this field is required',
            'designation_name.string'=>'this field must be string',
        ];
    }
}
