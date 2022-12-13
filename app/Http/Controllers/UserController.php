<?php

namespace App\Http\Controllers;

use App\Models\pizza;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //direct user homepage
    public function index(){
        $data=pizza::where('publish_status',1)->get();

        return view('user.home')->with(['pizza'=>$data]);
    }

    // Get data of contact
    public function contact(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'name' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data =$this->requestContactData($request);
        Contact::create($data);

        return back()->with(['contactSuccess'=>'Successfully Contacted..']);
    }


    private function requestContactData($request){
        return [
            'user_id'=>Auth()->user()->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message
        ];
    }
}
