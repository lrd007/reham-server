<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\LoginRequest;
use App\Http\Controllers\BaseController;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Where to redirect users after login..
     *
     * @return string
     */
    protected function redirectTo()
    {
        // check if user is admin.
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.home');
        }
        //return route('parent.dashboard');
        return redirect()->back();
    }

    /**
     * The login URL.
     *
     * @return string
     */
    protected function loginUrl()
    {
        $title = __('words.Login');
        return route('user.login',['title'=> $title]);
    }

    public function getLogin()
    {
        $title = __('words.Login');
        return view('website.Auth.login',['title' => $title]);
    }

    protected function getLogout()
    {
        // redirect to login page.
        return redirect()->route('user.login');
    }

    /**
     * Authentication.
     */
    public function postLogin(LoginRequest $request)
    {
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
        );

        if (!User::registered($request->get('email'))) {
            return redirect()
                ->route('user.login')
                // ->with("error", "Your have enter wrong email address.");
                ->withErrors(['email' => [__('You have enter wrong email address')]]);
        } elseif (!Auth::guard()->attempt($userdata)) {
            return redirect()
                ->route('user.login')
                //->with("error", "Your have enter wrong Password")
                ->withErrors(['password' => [__('You have enter wrong Password')]])
                ->withInput($request->except('password'));
        }

        if (Auth::guard()->attempt($userdata)) {
            Auth::user()->setLastLogin();

            // check if user is admin.
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.home');
            }

            //  return redirect()->route('parent.dashboard');
            return redirect()->back();
        } else {
            return redirect()
                ->route('user.login')
                //->with("error", "Your have enter wrong credentials.");
                ->withErrors(['email' => [__('You have enter wrong credentials')]]);
        }
    }

    public function logout()
    {
      //  Auth::user()->setLogout();
        Auth::guard()->logout();
        return $this->getLogout();
    }
}
