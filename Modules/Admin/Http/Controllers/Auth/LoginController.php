<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\AdminLoginRequest;
use Modules\User\Entities\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Where to redirect users after login..
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('admin.dashboard');
    }

    /**
     * The login URL.
     *
     * @return string
     */
    protected function loginUrl()
    {
        return route('admin.login');
    }

    protected function getLogout()
    {
        // return view('admin::auth.logout');
        // redirect to login page.
        return redirect()->route('user.login');
    }

    public function getLogin()
    {
        //  return view('admin::auth.login');
        return redirect()->route('user.login');
    }

    /**
     * Authentication.
     */
    public function postLogin(AdminLoginRequest $request)
    {
        $userdata = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        );

        if (!User::registeredAsAdmin($request->get('email'))) {
            return redirect()
                ->route('admin.login')
                ->with("error", "Your have enter wrong email address.");
        } elseif (!Auth::guard()->attempt($userdata)) {
            return redirect()
                ->route('admin.login')
                ->with("error", "Your have enter wrong Password")
                ->withInput($request->except('password'));
        }

        if (Auth::guard()->attempt($userdata)) {
            Auth::user()->setLastLogin();
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()
                ->route('admin.login')
                ->with("error", "Your have enter wrong credentials.");
        }
    }

    public function logout()
    {
        Auth::guard()->logout();
        return $this->getLogout();
    }
}
