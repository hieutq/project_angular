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
            'name'      =>'required|max:100',
            'gender'    =>'required|numeric',
            'age'       =>'required|numeric|digits:2',
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
            'name.required'         =>'Bạn Vui lòng điền tên của bạn',
            'name.max'              =>'độ dài tên của bạn tối thiểu chỉ 100 ký tự',
            'gender.required'       =>'Bạn vui lòng chọn giới tính ',
            'gender.numeric'       =>'Dữ liệu nhập vào không đúng định dạng số',
            'age.required'          =>'Bạn vui lòng điền tuổi',
            'age.numeric'           =>'Tuổi không đúng định dạng kiểu số',
            'age.digits'            =>'Tuổi chỉ được phép điền 2 chữ số',
        ];
    }
}
