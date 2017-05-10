<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\MemberRequest;
use App\Business\MemberObject;
use Validator;
use DB;

class MemberController extends Controller
{
    public function getList()
    {
        $datas = Member::listMember();
        return response()->json($datas);
    }

    public function getAdd(MemberRequest $request)
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
        return response()->json([
            'error' => true,
            'messages' => 'Create successfully'
        ]);
    }

    public function getEdit($id)
    {
        $data = Member::show($id);
        return response()->json($data);
    }

    public function postEdit(MemberRequest $request, $id)
    {
        $requestAll = $request->all();
        DB::beginTransaction();
        try {
            Member::edit($request, $id);
            DB::commit();
            return $this->getList();
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function deleteMember($id)
    {
        $customer = Member::show($id);
        $customer->delete();
        return response()->json([
            'messages' => 'Delete successfully'
        ]);
    }


    public function uploadImage(Request $request)
    {
        $rules = [
            'photo' => 'image|mimes:jpeg,png,gif|max:10240',

        ];
        $messages = [
            'photo.image' => 'The photo must be an image.',
            'photo.mimes' => 'The photo must be a file of type: jpeg, png, gif.',
            'photo.max' => 'The photo may not be greater than 10 MB.',
        ];
        $validator = Validator::make($requestAll, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => false,
                'messages' => $validator->errors(),
            ], 405);
        }
        if ($request->hasFile('photo')) {
            $imageName = rand(1111, 1000) . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images'), $imageName);
            return response()->json(['name' => $imageName]);
        }
    }
}
