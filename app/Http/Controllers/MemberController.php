<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\MemberRequest;
use Validator;
use DB;

class MemberController extends Controller
{
    public function getList()
    {
        $datas = Member::listMember();
        return response()->json($datas);
    }

    public function getAdd(Request $request)
    {
        $data = Member::Validate_rule($request->all(), Member::$rules, Member::$messages);

        if ($data['error']) {
            return response()->json([
                'error' => false,
                'messages' => $data['messages']
            ], 405);
        }
        Member::store($request);
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

    public function postEdit(Request $request, $id)
    {
        $requestAll = $request->all();
        $rules = [
            'name' => 'required|max:100',
            'gender' => 'required|numeric',
            'age' => 'required|numeric|digits:2',
            'address' => 'required|max:300',

        ];

        $messages = [
            'name.required' => 'Tell us your name.',
            'name.max' => 'your name wrong. max 100 string',
            'gender.required' => 'Tell us your gender.',
            'gender.numeric' => 'Your gender Your age must be a numberic',
            'age.required' => 'Tell us your age',
            'age.numberic' => 'Your age Your age must be a numberic',
            'age.digits' => 'Your age must be a a 2 digit number',
            'address.max' => 'The address may not be greater than 300 characters.',
            'address.required' => 'Tell us your address',

        ];

        $validator = Validator::make($requestAll, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => false,
                'messages' => $validator->errors(),
            ], 405);
        }

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
