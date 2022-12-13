<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    //direct Contact Page from admin
    public function contactList(){

        $data=Contact::orderBy('contact_id','desc')->paginate(5);
        if(count($data)==0){
            $emptyStatus=0;
        }else{
            $emptyStatus=1;
        }
        return view('admin.contact.list')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }

    // Search Contact information from admin
    public function contactSearch(Request $request){
        $data =Contact::orWhere('name','like','%'.$request->table_search.'%')
                        ->orWhere('email','like','%'.$request->table_search.'%')
                        ->orWhere('message','like','%'.$request->table_search.'%')
                        ->paginate(5);
        $data->appends($request->all());
        if(count($data)==0){
            $emptyStatus=0;
        }else{
            $emptyStatus=1;
        }

        return view('admin.contact.list')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }
}
