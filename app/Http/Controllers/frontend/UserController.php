<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function notification()
    {
        $user=Auth::user();
        $notifications=$user->notifications;
        return view('website.profile.notification',compact('notifications'));
    }

    public function profile()
    {
        $tilte = __('words.My Profile');
        return view('website.profile.main',['title' =>$tilte]);
    }

    public function UpdateProfileImage(Request $request){

        $user=Auth::user();
        $subscriber =$user->subscriber;
        $validateUser = Validator::make($request->all(),
            [
                'profile' => 'required|file|mimes:jpeg,png,jpg,svg|max:5048',
            ]);
        if ($validateUser->fails()) {
            return $this->apiResponse([
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], false, null, 401);
        }
        $date = date('Y-m-d');
        $destinationPath = public_path().'/images/'.$date.'/';

// Create folders if they don't exist
        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
        }
        $img = $request->file('profile');

        $logo = 'Dexter-'.$date.'-'.rand(0,9999999).'.' . $img->extension();

        $img->move(('images/'.$date), $logo);

        $ImageUrl = secure_url('/images/'.$date.'/'. $logo);

        $subscriber->image = $ImageUrl;
        $subscriber->save();
        return redirect()->back();

    }

    public function updatePassword(Request $request){
        $user = Auth::user();
        $title = 'تغيير كلمة المرور';
        if($request->isMethod('post')){
            $rules = [
                'current_password' => [
                    'required',
                    function ($attribute, $value, $fail) use ($user) {
                        if (!Hash::check($value, $user->password)) {
                            return redirect()->back()->with('error','Your password was not updated, since the provided current password does not match.');

                        }
                    }
                ],
                'new_password' => [
                    'required', 'min:6', 'confirmed', 'different:current_password'
                ]
            ];

            $input = $request->only(
                'current_password',
                'new_password',
                'new_password_confirmation'
            );

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return redirect()->back()->with('error',$validator->errors());
            }

            $user->password = $request->get('new_password');
            $user->save();

            return redirect()->back()->with('success','password updated');
        }else{

            return view('website.profile.updatePassword', compact('title'));
        }
    }
}
