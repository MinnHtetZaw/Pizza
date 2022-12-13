<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //direct admin profile page

    public function profile(){
        $id =auth()->user()->id;

        $userData = User::where('id',$id)->first();

        return view('admin.profile.index')->with(['user'=>$userData]);
    }

    //  Update Profile Information

    public function updateProfile($id,Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required',
            'phone'=> 'required',
            'address'=> 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $updateData=$this->requestUpdateData($request);

        User::where('id',$id)->update($updateData);

        return back()->with(['updateSuccess'=>'User Information Updated....']);

    }

    // Change Password Page

    public function change(){
        return view('admin.profile.changePassword');
    }

    // Change Password Function

    public function changePassword($id,Request $request){

        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword'=> 'required',
            'confirmPassword'=> 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data=User::where('id',$id)->first();
        $oldPassword=$request->oldPassword;
        $newPassword=$request->newPassword;
        $confirmPassword=$request->confirmPassword;

        $dbPass=$data['password'];

        if(Hash::check($oldPassword,$dbPass)){
            if(strlen($newPassword) >6 || strlen($confirmPassword) >6){
                if($newPassword == $confirmPassword){

                    $password=Hash::make($newPassword);

                    $data=User::where('id',$id)->update([
                        'password'=>$password
                    ]);

                    return back()->with(['updateSuccess'=>'New Password Updated...']);

                }else{
                    return back()->with(['notSameError'=>'New Password and Confirm Possword is not the same']);
                }

            }else{
                return back()->with(['lenghtError'=>'New Password must be greater than 6 characters!']);
            }

        }else{
            return back()->with(['notMatchError'=>'Old Password is not the same...Try Again!']);
        }


    }

    // Request Data information of User

    private function requestUpdateData($request){
            return [
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
            ];
    }

}
