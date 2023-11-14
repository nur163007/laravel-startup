<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\String\u;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $username = $request->username;
        $user = User::where('username',$username)->first();

        if($user->role == 3){
            if($user->emailverified == 1){
            return $next($request,$user);
            }
            else{
                return redirect('/api');
            }
        }
        else{
            return redirect('/api');
        }
    }
}
