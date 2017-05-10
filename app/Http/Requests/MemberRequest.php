<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name' => 'required|max:100|not_in:undefined',
            'gender' => 'required|numeric|not_in:undefined',
            'age' => 'required|numeric|digits:2',
            'address' => 'required|max:300|not_in:undefined',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tell us your name.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'gender.required' => 'Tell us your gender.',
            'gender.numeric' => 'The gender must be a number.',
            'age.required' => 'Tell us your age',
            'age.numberic' => 'The age must be a number.',
            'age.digits' => 'The age must be 2 digits.',
            'address.max' => 'The address may not be greater than 300 characters.',
            'address.required' => 'Tell us your address'
        ];
    }
}
