<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsStudent
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
        if (Session('userrole') != "student") {
            $userrole = Session('userrole');
            return redirect('/' . $userrole)->with('errormsg', 'You are not authorized to view this page');
        }
        return $next($request);
    }
}
