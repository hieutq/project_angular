<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Customer;
class CustomersController extends Controller
{
    public function getList() {
    	$datas =  Customer::orderby('id','DESC')->get();
    	return response()->json($datas);
    }

    public function getAdd (Request $request) {
    	$data = Customer::create($request->all());
    	$datas =  Customer::orderby('id','DESC')->get();
    	return response()->json($datas);
    }

    public function getEdit ($id) {
    	$id = $id;
    	$data = Customer::find($id);
    	return response()->json($data);
    }

    public function postEdit (Request $request ,$id) {
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = $file->getClientOriginalName();
            $image = $file->getClientOriginalExtension();
            $imageName = rand(1111,10000).'-'.$filename;
            $allowed = array('jpg','png','gif');
            $path = public_path('images');
            if (in_array($image, $allowed)) {
                $id = $id;
                $customer = Member::find($id);
                $customer->name = $request->name;
                $customer->gender = $request->gender;
                $customer->age = $request->age;
                $customer->address = $request->address;
                $customer->photo = $imageName;
                $file->move($path, $imageName);
                $customer->save();
                $datas =  Member::orderby('id','DESC')->get();
                return response()->json([
                    'error' => true,
                    'datas' => $datas,
                    'messages' => 'add images successfully'
                ]);
            }else{
                return response()->json([
                    'error' => false,
                    'messages' => 'select image wrong!'
                ]);
            }
            
        }
        else {
            $data = Member::select('photo')->where('id',$id)->pluck('photo');
            $imageName = $data[0];
            $customer = Member::find($id);
            $customer->name = $request->name;
            $customer->gender = $request->gender;
            $customer->age = $request->age;
            $customer->address = $request->address;
            $customer->photo = $imageName;
            $customer->save();
            $datas =  Member::orderby('id','DESC')->get();
            return response()->json($datas);
        }

    }

    public function deleteMember ($id) {
    	$customer = Customer::find($id);
    	$customer->delete();
    	$datas =  Customer::orderby('id','DESC')->get();
    	return response()->json($datas);
    }
}
