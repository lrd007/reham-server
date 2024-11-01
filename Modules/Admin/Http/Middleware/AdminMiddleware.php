<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * The routes that should be excluded from verification.
     *
     * @var array
     */
    protected $except = [
        'admin.login.*',
        'admin.reset.*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isParent()) {
            return redirect()->route('admin.dashboard');
        }

        if ($this->inExceptArray($request) || auth()->check()) {
            return $next($request);
        }

        return redirect()->guest(route('admin.login'));
    }

    /**
     * Determine if the request URI is in except array.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            $routeName = optional($request->route())->getName();

            if (preg_match("/{$except}/", $routeName)) {
                return true;
            }
        }

        return false;
    }
}
