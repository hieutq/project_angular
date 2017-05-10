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
        
        Member::store();
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
}
