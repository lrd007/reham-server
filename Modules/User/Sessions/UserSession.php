<?php

namespace Modules\User\Sessions;

use Modules\User\Entities\User;
use Session;

class UserSession
{
    public function create($request)
    {
        return $this->store($request);
    }

    private function store($request)
    {
        if (!User::registered(Session::get('email'))) {
            $user = new User;
        } else {
            $user = User::where('email', Session::get('email'))->first();
        }

        $user->email = Session::get('email');
        $user->password = bcrypt(Session::get('password'));
        $user->save();

        return $user;
    }
}
