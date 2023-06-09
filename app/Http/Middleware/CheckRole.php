<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $role2 = null)
    {
        $roles = array($role, $role2);
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Redirect...
            return Redirect::route('login');
        }
        return $next($request);
    }
}
