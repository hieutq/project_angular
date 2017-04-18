<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
class Member extends Model
{
     protected $table = 'members';
     protected $fillable = ['name','gender','age','address','photo','status'];


    public static $rules = [
        'name'      =>'required|max:100',
        'gender'    =>'required|numeric',
        'age'       =>'required|numeric|digits:2',
        'photo'     =>'required|image|mimes:jpeg,png,gif|max:10240',
        'address'   =>'required|max:300',

    ];

    public static $messages = [
        'name.required'         => 'Tell us your name.',
        'name.max'              => 'The name may not be greater than 100 characters.',
        'gender.required'       => 'Tell us your gender.',
        'gender.numeric'        => 'The gender must be a number.',
        'age.required'          => 'Tell us your age',
        'age.numberic'          => 'The age must be a number.',
        'age.digits'            => 'The age must be 2 digits.',
        'photo.required'        => 'Selected a image',
        'photo.image'           => 'The photo must be an image.',
        'photo.mimes'           => 'The photo must be a file of type: jpeg, png, gif.',
        'photo.max'             => 'The photo may not be greater than 10 MB.',
        'address.max'           => 'The address may not be greater than 300 characters.',  
        'address.required'      => 'Tell us your address'                 
    ];

    /**
     * validate form.
     *
     * @var array
     */
    public static function Validate_rule($input, $rules, $messages) {
        $validator =Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return [
                'error' => true,
                'messages' => $validator->errors()
           ];
        }
        return [
            'error' => false,
            'messages' => 'successfully'
        ];
    }
}
