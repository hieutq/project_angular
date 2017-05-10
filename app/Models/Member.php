<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['name', 'gender', 'age', 'address', 'photo', 'status'];


    public static $rules = [
        'name' => 'required|max:100',
        'gender' => 'required|numeric',
        'age' => 'required|numeric|digits:2',
        'photo' => 'image|mimes:jpeg,png,gif|max:10240',
        'address' => 'required|max:300',

    ];

    public static $messages = [
        'name.required' => 'Tell us your name.',
        'name.max' => 'The name may not be greater than 100 characters.',
        'gender.required' => 'Tell us your gender.',
        'gender.numeric' => 'The gender must be a number.',
        'age.required' => 'Tell us your age',
        'age.numberic' => 'The age must be a number.',
        'age.digits' => 'The age must be 2 digits.',
        'photo.image' => 'The photo must be an image.',
        'photo.mimes' => 'The photo must be a file of type: jpeg, png, gif.',
        'photo.max' => 'The photo may not be greater than 10 MB.',
        'address.max' => 'The address may not be greater than 300 characters.',
        'address.required' => 'Tell us your address'
    ];

    /**
     * validate form.
     *
     * @var array
     */
    public static function Validate_rule($input, $rules, $messages)
    {
        $validator = Validator::make($input, $rules, $messages);
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
        $datas = Member::where('status', '=', 1)->get();
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
     *         if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images'), $imageName);
            $data['photo'] = $imageName;
        }else {
            $data['photo'] = "";
        }
     *
     * @var array
     */
    public static function store($request)
    {
        $data = $request->all();
        if (isset($request->photo) && $request->photo != 'undefined' && $request->photo) {
             $ext = $request->photo->getMimeType();
              if (in_array($ext,['image/jpeg', 'image/png', 'image/jpg', 'gif'])) {
                if ($request->photo->getSize() > 10485760) {
                    //get original name of picture.
                   $thumbnail = time()."-".$request->photo->getClientOriginalName();

                   //get the extension of picture.
                   // $arrayImage = explode('.', $thumbnail);
                   // $extension = end($arrayImage);

                   //get the only name of the picture.
                   // $cutName = explode(".".$extension, $thumbnail);
                   // $newName = time()."-".reset($cutName);

                   //create new picture.
                   // $newThumbnail = $newName.".".$extension;

                   //move image to appropriate Folder:
                   $request->photo->move(public_path('images'), $thumbnail);

                   $member->photo = $thumbnail;
                } else {
                    return response()->json([
                        'messages' => 'The photo may not be greater than 10 MB.'
                    ]);
                }
              } else {
                return response()->json([
                    'messages' => 'The photo must be a file of type: jpeg, png, gif.'
                ]);
              }
        }
        $data['name'] = trim($request->name);
        $data['gender'] = trim($request->gender);
        $data['age'] = trim($request->age);
        $data['address'] = trim($request->address);
        $datas = Member::create($data);
        return $datas;
    }

    /**
     * Edit a Member.
     *
     * @var array
     */
    public static function edit($request, $id)
    {
        $member = Member::find($id);
        if (isset($request->photo) && $request->photo != 'undefined' && $request->photo) {

             $ext = $request->photo->getMimeType();

              if (in_array($ext,['image/jpeg', 'image/png', 'image/jpg', 'gif'])) {
                
                if ($request->photo->getSize() < 10485760) {

                    //get original name of picture.
                   $thumbnail = time()."-".$request->photo->getClientOriginalName();

                   //move image to appropriate Folder:
                   $request->photo->move(public_path('images'), $thumbnail);

                   $member->photo = $thumbnail;

                } else {
                    return response()->json([
                        'messages' => 'more 10MB'
                    ]);
                }
              } else {
                return response()->json([
                    'messages' => 'select image wrong!'
                ]);
               
              }
        } 
        $member->name = trim($request->name);
        $member->gender = trim($request->gender);
        $member->age = trim($request->age);
        $member->address = trim($request->address);
        $member->save();
        return $member;
    }
}
