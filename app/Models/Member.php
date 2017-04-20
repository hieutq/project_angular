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
    'photo'     =>'image|mimes:jpeg,png,gif|max:10240',
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
        // 'photo.required'        => 'Selected a image',
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
    public static function Validate_rule($input, $rules, $messages)
    {
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

    /**
     * List Member.
     *
     * @var array
     */
    public static function listMember()
    {
        $datas = Member::all();
        return $datas;
    }

    /**
     * show a Member.
     *
     * @var array
     */
    public static function show($id)
    {
        $datas = Member::find($id);
        return $datas;
    }

    /**
     * add new a Member.
     *
     * @var array
     */
    public static function store($request)
    {
        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images'), $imageName);
            $data = $request->all();
            $data['name']       = trim($request->name);
            $data['gender']     = trim($request->gender);
            $data['age']        = trim($request->age);
            $data['address']    = trim($request->address);
            $data['photo']      = $imageName;
            $datas = Member::create($data);
            return $datas;
        }
    }

    /**
     * Edit a Member.
     *
     * @var array
     */
    public static function edit($request,$id)
    {
        $customer=Member::find($id);
        if ($request->hasFile('photo')) {
            $rules = [
            'photo'     =>'image|mimes:jpeg,png,gif|max:10240',

            ];
            $messages = [
            'photo.image'           => 'The photo must be an image.',
            'photo.mimes'           => 'The photo must be a file of type: jpeg, png, gif.',
            'photo.max'             => 'The photo may not be greater than 10 MB.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'error' => false,
                    'messages' => 'thêm ảnh thành công',
                    ], 200);
            }
            $imageName = rand(1111, 1000).'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images'), $imageName);

            $customer->photo    = $imageName;
        } 
        $customer->name     = trim($request->name);
        $customer->gender   = trim($request->gender);
        $customer->age      = trim($request->age);
        $customer->address  = trim($request->address);
        $customer->save();
        return $customer;

    }
}




