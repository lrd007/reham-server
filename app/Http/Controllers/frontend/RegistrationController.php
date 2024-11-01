<?php

namespace App\Http\Controllers\frontend;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Subscriber\Entities\Subscriber;
use Modules\User\Entities\User;

class RegistrationController extends Controller
{
    public function register()
    {
        $title = __('words.Register');
        $countries=Country::all();
        return view('website.Auth.register',compact('countries','title'));
    }

    public function register_post(Request $request)
    {
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);
        //$token =  $user->createToken($user->name . ' token')->plainTextToken;

        $susbcriber = Subscriber::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_no' => $request->mobile_no,
            'country_id' => $request->country_id,
            'user_id' => $user->id,
        ]);
        return redirect()->route('user.login');
    }
}
