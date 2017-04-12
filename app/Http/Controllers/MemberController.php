<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Member;
use App\Http\Requests\MemberRequest;
use Validator;
use DB;
class MemberController extends Controller
{
   public function getList() {
        $datas =  Member::orderby('id','DESC')->get();
        return response()->json($datas);
    }

    public function getAdd (Request $request) {
        $data = $request->all();
        $rules = [
            'name'      =>'required|max:100',
            'gender'    =>'required|numeric',
            'age'       =>'required|numeric|digits:2',
            'photo'     =>'required|image|mimes:jpeg,png,gif|max:10240',

        ];

        $messages = [
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


        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 200);
        }

        DB::beginTransaction();
        try {
            $imageName = time().'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('images'), $imageName);
            $data = $request->all();
            $data['photo'] = $imageName;
            $datas = Member::create($data);
            DB::commit();
            return $this->getList();
        } catch (Exception $e) {
            DB::rollback();
        }   
    }

    public function getEdit ($id) {
        $id = $id;
        $data = Member::find($id);
        return response()->json($data);
    }

    public function postEdit (Request $request ,$id) {
        $requestAll = $request->all();
        $rules = [
            'name'      =>'required|max:100',
            'gender'    =>'required|numeric',
            'age'       =>'required|numeric|digits:2',

        ];

        $messages = [
            'name.required'         => 'Tell us your name.',
            'name.max'              => 'your name wrong. max 100 string',
            'gender.required'       => 'Tell us your gender.',
            'gender.numeric'        => 'Your gender Your age must be a numberic',
            'age.required'          => 'Tell us your age',
            'age.numberic'          => 'Your age Your age must be a numberic',
            'age.digits'            => 'Your age must be a a 2 digit number',

        ];

        $validator = Validator::make($requestAll, $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors(),
            ], 200);
        }

        DB::beginTransaction();
        try {
            if (!$request->hasFile('photo')) {
                $customer = Member::find($id);
                $customer->name = $request->name;
                $customer->gender = $request->gender;
                $customer->age = $request->age;
                $customer->address = $request->address;
                $customer->save();
                return $this->getList();
                
            }
            else {
                    $imageName = rand(1111,1000).'.'.$request->photo->getClientOriginalExtension();
                    $request->photo->move(public_path('images'), $imageName);
                    $id = $id;
                    $customer = Member::find($id);
                    $customer->name = $request->name;
                    $customer->gender = $request->gender;
                    $customer->age = $request->age;
                    $customer->address = $request->address;
                    $customer->photo = $imageName; 
                    $customer->save();

                    DB::commit();
                    return $this->getList();    
                
                
            }
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function deleteMember ($id) {
        $customer = Member::find($id);
        $customer->delete();
        return $this->getList();
    }


    public function uploadImage (Request $request) {
        dd($request->photo);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $file->getClientOriginalName();
            $image = $file->getClientOriginalExtension();
            $imageName = rand(1111,10000).'-'.$filename;
            $allowed = array('jpg','png','gif');
            $path = public_path('images');
            if (in_array($image, $allowed)) {
                $file->move($path, $imageName);
                return response()->json([
                    'error' => true,
                    'pathFile' => $imageName,
                ]);
            }else {
                return response()->json([
                    'error' => false,
                    'messages' => 'image format wrong!'
                ]);
            }
        }
    }
}
