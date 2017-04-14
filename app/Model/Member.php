<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;
class Member extends Model
{
    use SoftDeletes;
     protected $table = 'members';
     protected $fillable = ['name','gender','age','address','photo','status'];


    public static $rules = [
        'name'      =>'required|max:100',
        'gender'    =>'required|numeric',
        'age'       =>'required|numeric|digits:2',
        'photo'     =>'required|image|mimes:jpeg,png,gif|max:10240',

    ];

    public static $messages = [
        'name.required'         => 'Tell us your name.',
        'name.max'              => 'your name wrong. max 100 string',
        'gender.required'       => 'Tell us your gender.',
        'gender.numeric'        => 'Your gender Your age must be a numberic',
        'age.required'          => 'Tell us your age',
        'age.numberic'          => 'Your age Your age must be a numberic',
        'age.digits'            => 'Your age must be a a 2 digit number',
        'photo.required'        => 'Selected a image',
        'photo.image'           => 'The photo must be an image.',
        'photo.mimes'           => 'The photo must be a file of type: jpeg, png, gif.',
        'photo.max'             => 'The photo may not be greater than 10 MB.'                  
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
