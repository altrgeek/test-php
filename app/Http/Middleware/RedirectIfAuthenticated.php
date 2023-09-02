<?php

namespace App\Http\Middleware;

use App\Traits\RedirectsToDashboard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    use RedirectsToDashboard;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        //  If the user is logged in then redirect to appropriate dashboard
        if (Auth::check())
            return $this->redirectToDashboard($request, Auth::user());

        return $next($request);
    }
}
