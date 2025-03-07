<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            return redirect('login');
        }
        $user = Auth::user();
        $roles = Auth::user();

        if ($user->role == $roles)
        return $next($request);
        
        return redirect('login')->with('error', 'anda belum terdaftar');
    }
}
