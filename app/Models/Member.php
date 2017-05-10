<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['name', 'gender', 'age', 'address', 'photo', 'status'];

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


    /*
        Add new Member
     */
    
    public static function store ($request) 
    {
        $data = new Member();
        if (isset($request->photo) && $request->photo != 'undefined' && $request->photo) {

             $ext = $request->photo->getMimeType();

              if (in_array($ext,['image/jpeg', 'image/png', 'image/jpg', 'gif'])) {
                
                if ($request->photo->getSize() < 10485760) {

                    //get original name of picture.
                   $thumbnail = time()."-".$request->photo->getClientOriginalName();

                   //move image to appropriate Folder:
                   $request->photo->move(public_path('images'), $thumbnail);

                   $data->photo = $thumbnail;

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
        if (isset($request->name) && $request->name != 'undefined' && $request->name) {
            $data->name = $request->name;
        }
        if (isset($request->gender) && $request->gender != 'undefined' && $request->gender) {
            $data->gender = $request->gender;
        }
        if (isset($request->age) && $request->age != 'undefined' && $request->age) {
            $data->age = $request->age;
        }
        if (isset($request->address) && $request->address != 'undefined' && $request->address) {
            $data->address = $request->address;
        }
        $data->save();
        return $data;
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
