<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //direct User Data page
    public function user(){
        $data=User::where('role','user')->paginate(7);
        return view('admin.user.userList')->with(['user'=>$data]);
    }

     //direct Admin Data page
     public function admin(){
        $data=User::where('role','admin')->paginate(7);
        return view('admin.user.adminList')->with(['admin'=>$data]);
    }

    // Search User Data
    public function userSearch(Request $request){

       $response = $this->searchUserData('user',$request);

        return view('admin.user.userList')->with(['user'=>$response]);
    }

    // Delete User Data
    public function userDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'User Information Deleted..']);
    }

    // Search Admin Data
    public function adminSearch(Request $request){
        $response =$this->searchUserData('admin',$request);

        return view('admin.user.adminList')->with(['admin'=>$response]);
    }


    // Search All Data
    private function searchUserData($role,$request){

        $data = User::where('role',$role)
                    ->where(function ($query) use($request){
                        $query->orWhere('name','like','%'.$request->searchData.'%')
                              ->orWhere('phone','like','%'.$request->searchData.'%')
                              ->orWhere('email','like','%'.$request->searchData.'%')
                              ->orWhere('address','like','%'.$request->searchData.'%');
                    })
                    ->paginate(7);
                    $data->appends($request->all());

        return $data;
    }




}

