<?php

namespace Modules\User\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard()->check()) {
            //$route = auth()->user()->isAdmin() ? 'admin.dashboard' : 'parent.dashboard';
            $route = auth()->user()->isAdmin() ? 'admin.dashboard' : 'index';
            return redirect()->route($route);
        }

        return $next($request);
    }
}
