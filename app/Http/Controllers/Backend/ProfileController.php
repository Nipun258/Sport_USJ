<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function ProfileView()
    {
    	$id = Auth::user()->id;
    	$user = User::find($id);

    	return view('backend.profile.view',compact('user'));
    }

    public function ProfileEdit()
    {
    	$id = Auth::user()->id;
    	$editData = User::find($id);

    	return view('backend.profile.edit',compact('editData'));
    }

    public function ProfileStore(Request $request)
    {
    	 $data = User::find(Auth::user()->id);
    	 $data->name = $request->name;
         $data->email = $request->email;
         $data->mobile = $request->mobile;
    	 $data->address = $request->address;
         $data->gender = $request->gender;

         if ($request->file('image')) {
         	
         	$file = $request->file('image');
         	@unlink(public_path('upload/user_images'.$data->image));
         	$filename = date('YmdHi').$file->getClientOriginalName();
         	$file->move(public_path('upload/user_images'),$filename);
         	$data['image'] = $filename;

         }
         $data->save();

         $notification = array(
           'message' => 'User profile update Successfully',
           'alert-type' => 'success'
        );

        return redirect()->route('profile.view')->with($notification);
    }//profile update page

    public function PasswordView()
    {
    	$id = Auth::user()->id;
    	$user = User::find($id);

    	return view('backend.profile.edit_password',compact('user'));

    }

    public function PasswordUpdate(Request $request){
 		$validatedData = $request->validate([
    		'oldpassword' => 'required',
    		'password' => 'required|confirmed',
    	]);


    	$hashedPassword = Auth::user()->password;
    	if (Hash::check($request->oldpassword,$hashedPassword)) {
    		$user = User::find(Auth::id());
    		$user->password = Hash::make($request->password);
    		$user->save();
    		Auth::logout();
    		return redirect()->route('login');
    	}else{
    		return redirect()->back();
    	}


 	} // End Metod 
}
